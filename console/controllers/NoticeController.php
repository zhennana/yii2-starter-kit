<?php
namespace console\controllers;
use Yii;
use yii\console\Controller;
use yii\helpers\Console;
use \backend\modules\campus\models\Notice;
use \backend\modules\campus\models\UserToSchool;
use \backend\modules\campus\models\UserToGrade;
use \common\components\APush\APush;
/**
 * @author Eugene Terentev <eugene@terentev.net>
 */
class NoticeController extends Controller
{



 // $data =
    //         [
    //           'client_source_type' =>'',
    //            'cid'                 =>'',
    //            'message'            =>
    //            [
    //             'title' =>'',
    //             'body'  =>'',
    //            ],
    //          ]
    // ;
  public function actionSendMessage(){
     $this->InitData();
     $model = Notice::find()->where([
                    'is_a_push'=>1,
                    'status_send'=>Notice::STATUS_SEND_UNSENT,
      ])
     ->andwhere(['not',['type'=>NULL]])
     ->all();
     $callback = [];
     foreach ($model as $key => $value) {
        $cid =  isset($value->user->userProfile->clientid) ? $value->user->userProfile->clientid : NULL;
        $client_source_type = isset($value->user->userProfile->client_source_type) ? $value->user->userProfile->client_source_type : NULL;
        if(!empty($cid) && !empty($client_source_type)){
          //消息发送需要的结构
            $message = [
                  'client_source_type'=>$client_source_type,
                  'cid'               =>$cid,
                  'message'           =>[
                      'title' =>$value->title,
                      'body'  =>$value->message,
                  ]
            ];
            $APush = new APush;
            $rep = $APush->pushMessageToSingle($message);
            var_dump($cid,$rep);
            if($rep['result'] == "ok"){
              $callback[] = $rep;
              $value->times++;
              $value->status_send = 10;
              $value->save();
            }
        }
     }
     echo '共推送'.count($callback).'次';
  }

  //初始化数据 
  public function InitData(){
      $data  = [];
      $model = Notice::find()->where([
                    'is_a_push'=>1,
                    'type'     =>0,
                   'status_send'=>Notice::STATUS_SEND_UNSENT,
        ])->all();
      foreach ($model as $key => $value) {
        //STATUS_SEND_SENT
          $value->status_send = Notice::STATUS_SEND_SENT;
          $value->save();

          //家校沟通（老师对学生发的）
          if($value->receiver_id && $value->category == Notice::CATEGORY_TWO){
              $data[] =[
                  'type'=>Notice::TYPE_PUSH_STUDENT,
                  'category'=>0,
                  'school_id'    =>  $value->school_id,
                  'receiver_id'  =>  $value->receiver_id,
                  'grade_id'     =>  $value->grade_id,
                  'sender_id'    =>  $value->sender_id,
                  'message_hash' => md5($value->message),
                  'title'        => '家校沟通',
                  'message'      => $value->message,
                  'times'        => 0,
                  'is_a_push'    => 1,
                  'status_send'  => Notice::STATUS_SEND_UNSENT,
              ];
          }
          //个人推送
          if($value->receiver_id && $value->category == Notice::CATEGORY_ONE && !$value->school_id){
               $data[] =[
                  'type'=>Notice::TYPE_PUSH_PERSONAL,
                  'category'=>0,
                  'school_id'   => $value->school_id,
                  'receiver_id' => $value->receiver_id,
                  'grade_id'    => $value->grade_id,
                  'sender_id'   => $value->sender_id,
                  'message_hash' => md5($value->message),
                  'title'        => '个人推送',
                  'message'      => $value->message,
                  'times'        =>0,
                  'is_a_push'    =>1,
                  'status_send'  => Notice::STATUS_SEND_UNSENT,
               ];
          }

          //教师推送
          if($value->receiver_id && $value->category == Notice::CATEGORY_ONE && $value['school_id']){
               $data[] =[
                  'type'=>Notice::TYPE_PUSH_TEACHER,
                  'category'=>0,
                  'school_id'   => $value->school_id,
                  'receiver_id' => $value->receiver_id,
                  'grade_id'    => $value->grade_id,
                  'sender_id'   => $value->sender_id,
                  'message_hash' => md5($value->message),
                  'title'        => '个人推送',
                  'message'      => $value->message,
                  'times'        =>0,
                  'is_a_push'    =>1,
                  'status_send'  => Notice::STATUS_SEND_UNSENT,
               ];
          }

          //班级推送
          if(!$value->receiver_id && $value->grade_id && $value->school_id && $value->category == Notice::CATEGORY_ONE ){
              $user_to_grade  = UserToGrade::find()->where(['grade_id'=>$value->grade_id,'status'=>UserToGrade::USER_GRADE_STATUS_NORMAL])
              ->asArray()
              ->all();
              foreach ($user_to_grade as  $grade) {
                    $data[$grade['user_id']] = [
                            'type'        => Notice::TYPE_PUSH_GRADE,
                            'category'    => 0,
                            'grade_id'    => $value->grade_id,
                            'school_id'   => $grade['school_id'],
                            'receiver_id' => $grade['user_id'],
                            'message'     => $value->message,
                            'message_hash'=> md5($value->message),
                            'sender_id'   => $value->sender_id,
                            'title'       =>'班级公告',
                            'times'       => 0,
                            'is_a_push'   => 1,
                            'status_send' => Notice::STATUS_SEND_UNSENT,
                  ];
              }
          }

          //学校推送的消息
          if(!$value->receiver_id && !$value->grade_id &&  $value->school_id && $value->category == Notice::CATEGORY_ONE){
               $user_to_school = UserToSchool::find()->where(['school_id'=>$value->school_id , 'status'=>UserToSchool::SCHOOL_STATUS_ACTIVE])->asArray()->all();

              foreach ($user_to_school as $k => $v) {
                  $data[$v['user_id']] = [
                      'type'        => Notice::TYPE_PUSH_SCHOOL,
                      'category'    => 0,
                      'grade_id'    => $value->grade_id,
                      'school_id'   => $v['school_id'],
                      'receiver_id' => $v['user_id'],
                      'message'     => $value->message,
                      'message_hash'=> md5($value->message),
                      'sender_id'   => $value->sender_id,
                      'title'       =>'学校公告',
                      'times'       => 0,
                      'is_a_push'   => 1,
                      'status_send' => Notice::STATUS_SEND_UNSENT,
                  ];
            }
          }

/*
          //家校沟通来源
          if($value['receiver_id'] != NULL){
              $data[] =[
                  'type'=>Notice::TYPE_PUSH_TEACHER,
                  'category'=>0,
                  'school_id'   => $value->school_id,
                  'receiver_id' => $value->receiver_id,
                  'grade_id'=> $value->grade_id,
                  'sender_id'   => $value->sender_id,
                  'message_hash'     => md5($value->message),
                  'title'       => '教师公告',
                  'message'        => $value->message,
                  'times'       =>0,
                  'is_a_push'   =>1,
                  'status_send' =>Notice::STATUS_SEND_UNSENT,
              ];
          }else{
            $user_to_school = UserToSchool::find()->where(['school_id'=>$value->school_id , 'status'=>UserToSchool::SCHOOL_STATUS_ACTIVE])->asArray()->all();
            foreach ($user_to_school as $k => $v) {
                $data[] = [
                    'type'        => Notice::TYPE_PUSH_SCHOOL,
                    'category'    => 0,
                    'grade_id'    => $value->grade_id,
                    'school_id'   => $v['school_id'],
                    'receiver_id' => $v['user_id'],
                    'message'     => $value->message,
                    'message_hash'=> md5($value->message),
                    'sender_id'   => $value->sender_id,
                    'title'       =>'学校公告',
                    'times'       => 0,
                    'is_a_push'   => 1,
                    'status_send' => Notice::STATUS_SEND_UNSENT,
                ];
            }
}*/
      }
      //var_Dump($data);exit;
      //var_dump($data);exit;
      return $this->AddNotice($data);
  }
  public function AddNotice($data){
    foreach ($data as $key => $value) {
        $model = new Notice;
        $model->load($value,'');
        $model->save();
    }
    return true;
  }
}
