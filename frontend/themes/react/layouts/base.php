<?php

use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;

/* @var $this \yii\web\View */
/* @var $content string */

$this->beginContent('@frontend/views/layouts/_clear.php')
?>
<div class="wrap">
    <?php echo $content ?>
</div>

<footer class="footer" id="footer_mobile">

</footer>
<?php $this->endContent() ?>

<script type="text/babel">
var footer;
footer = React.createClass({
getInitailState: function (){
    return {
        index: 0,
    }
},
handleClick: function(i) {
    this.setState({
        index: i,
    });
},
render: function () {
    var msg=[
        {
            'icon':'icon-home',
            'name':'首页',
            'index': 0,
        },
        {
            'icon':'icon-bulb',
            'name':'发现',
            'index': 1,
        },
        {
            'icon':'icon-person',
            'name':'我的',
            'index': 2,
        }
    ];
    var $nodes = msg.map(function (v) {
        return (
            <Nav
                onClick={function(){this.handleClick(v.index)}}
                className={this.state.index == v.index ? 'footer-nav active' : 'footer-nav'}
                icon={v.icon}>
                {v.name}
            </Nav>
        );
    });
    return(
        <footer className="footer">
            {$nodes}
        </footer>
    );
}
});
</script>
