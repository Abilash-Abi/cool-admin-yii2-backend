<?php
$this->registerJs(
    "
    $('.confirm-delete').on('click',function(e){
        e.preventDefault();
        let url =  $(this).attr('href');
        $.confirm({
            title: 'Confirm!',
            content: 'Are you sure want to delete this item? ',
            buttons: {
                confirm: function () {
                    window.location = url;
                },
                cancel: function () {
                },
               
            }
        });
                                        
    });
    "
);
?>