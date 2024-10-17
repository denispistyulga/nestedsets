<?php

use yii\web\JsExpression;
use yii\widgets\Pjax;

?>


<?
$this->title='Nested Sets';
if (!empty($status)){
    echo '<h3>'.$status.'</h3>';
}


//$data = [
//    ['title' => 'Node 1', 'key' => 1],
//    ['title' => 'Folder 2', 'key' => '2', 'folder' => true, 'children' => [
//        ['title' => 'Node 2.1', 'key' => '3'],
//        ['title' => 'Node 2.2', 'key' => '4']
//    ]]
//];
?>

<div class="row">
    <div class="col-lg-6">
        <h2>Дерево папок</h2>
        <?

        echo \wbraganca\fancytree\FancytreeWidget::widget([
            'options' =>[
                'source' => $data,
                'extensions' => ['dnd'],
                'dnd' => [
                    'preventVoidMoves' => true,
                    'preventRecursiveMoves' => true,
                    'autoExpandMS' => 400,
                    'dragStart' => new JsExpression('function(node, data) {
				return true;
			}'),
                    'dragEnter' => new JsExpression('function(node, data) {
				return true;
			}'),
        //Событие перетаскивания
                    'dragDrop' => new JsExpression('function(node, data) {                          
                            
                            $.get("/menu/menu/move",
                                                     {
                                                     item: data.otherNode.data.id, 
                                                     action: data.hitMode, 
                                                     second: node.data.id
                                                     }, 
                                                     
                                                     
                             function(){
                                     data.otherNode.moveTo(node, data.hitMode);
                             }).done(function() {
                                    alert("Перемещено успешно");
                                  })
                                  .fail(function() {
                                    alert("Так нельзя перемещать");
                                  });				
			},
			
			'),
                ],


//Событие при нажатии на элемент дерева
                'activate'=>new JsExpression('function(node, data) { 
                        let item_title=data.node.title;  
                        $("#item_title_1").text(item_title);  
                        
                        id_key=data.node.data.id;   
                        $("#item_content_title").text(id_key);   
                                            
                        $.get("/menu/menu/view-ajax", {id:id_key}, function (data) {
                        $("#item_content").html(data);
                        });
                    }')




            ]
        ]);

        ?>

    </div>

    <div class="col-lg-6">
        <h2>Содержимое выбранной папки</h2>
<!--        <h4>Наименование элемента - <span style="color: darkblue" id="item_title_1"></span></h4>-->
        <h5>Содержимое элемента <span id="item_content_title"></span></h5>
        <div id="item_content"></div>
    </div>
</div>




<div class="row">
<div class="col-lg-12">
    <?
    try {
        //Рендер таблицы папок
       Pjax::begin();
        echo $this->render('@app/views/menu/menu/index.php', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
        Pjax::end();
    } catch (Exception $e) {
        echo $e->getMessage();
    }
    ?>

</div>
</div>

