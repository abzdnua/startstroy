$(document).ready(function(){
    (function(cash) {
        $.fn.wrapSelected = function(open, close) {
            return this.each(function() {
                var textarea = $(this);
                var value = textarea.val();
                var start = textarea[0].selectionStart;
                var end = textarea[0].selectionEnd;
                if (value.substring(start, end)!=0)
                    textarea.val(
                        value.substr(0, start) +
                            open + value.substring(start, end) + close +
                            value.substring(end, value.length)
                    );
            });
        };
    })(jQuery);



    $(document).on('click','#add_new',function(){
        $('#form').show()
        $('#form input, #form textarea').val('')
        $('#id_img_edit_img').hide()
        $('#id_img_edit').hide()
    }).on('click','[name=save]',function(){
            var th = $(this)
            console.log('123')
            if($('[name=article_name]').val()=='')  {
                $('[name=article_name]').css('border','1px solid red').focus()
                return false
            }

            else
            {
                $('[name=article_name]').css('border','')
            }
            if($('[name=article_text]').val()=='')  {
                $('[name=article_text]').css('border','1px solid red').focus()
                return false
            }

            else
            {
                $('[name=article_text]').css('border','')
            }
            if($('[name=article_img_val]').val()=='')  {
                $('[name=article_img]').css('color','red').focus()
                return false
            }
            else
            {
                $('[name=article_img]').css('color','black')
            }

            if($('[name=article_img_val]').val()=='')  {
                $('[name=article_img]').css('color','red').focus()
                return false
            }
            else
            {
                $('[name=article_img]').css('color','black')
            }
            {
                var data = {
                    url: 'views/admin/ajax/articles/save.php',
                    beforeSubmit: function(jqForm){
                        $(this).attr('disabled','disabled')
                        console.log(jqForm)
                    },
                    success: function(responseText){
                        console.log(responseText)
                        if(responseText == '')
                        {
                            location.reload();
                        }
                        else{
                            alert(responseText)
                            th.removeAttr('disabled')
                        }

                    }
                }
                th.attr('disabled',true)
                $(this).parents('form').ajaxSubmit(data)
                return false;
            }
        }).on('click','.edit',function(){
            $.post('/views/admin/ajax/articles/getArticle.php',{id:$(this).data('id')},function(data){
//                alert(data)
                $('#form').html(data).show()

            })



        }).on('click','.del',function(){
            if(confirm('Удалить статью?'))
            {
                var th = $(this)
                var id=th.data('id')
                console.log(id)
                $.ajax({
                    type:"POST",
                    url: 'views/admin/ajax/articles/delete.php',
                    data:{id:id},
                    success:(function(responseText){
                        console.log(responseText)
                        if(responseText.indexOf('error') == -1){
                            th.parent().parent().remove();
                        }
                    })
                })
            }
        }).on('change','[name=article_thumb]',function(){
            $('[name=article_thumb_val]').val($('[name=article_thumb]').val())

        }).on('change','[name=article_img]',function(){
            $('[name=article_img_val]').val($('[name=article_img]').val())

        }).on('click','.b',function(){$("textarea").wrapSelected("<b>", "</b>");return false;})
    .on('click','.i',function(){$("textarea").wrapSelected("<i>", "</i>");return false;})
    .on('click','.l',function(){
        var y=prompt('Введите URL','http://');
        if (y.substr(8,1))
        {
            $("textarea").wrapSelected('<a href="'+y+'">', '</a>');
            console.log('<a href="'+y+'">');
            return false;
        }
    })

})