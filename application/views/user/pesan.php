<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/style.css') ?>">

<!-- <div class="page-header mt-4">
    <h3>Pesan</h3>
 </div> -->
 
 <p>
 <button class="btn btn-primary btn-sm mt-5" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
 <i class="glyphicon glyphicon-plus"></i> Tambah Pesan
  </button>
 </p>
 
 
 <div class="row">
    <div class="col-lg-6 collapse" id="collapseExample">      
        <form method="get" action="<?php echo site_url('profil_member/tambah_pesan'); ?>" class="needs-validation" novalidate>
        <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="cari username" name="cari" id="cari" aria-describedby="button-addon2" required>
            <div class="input-group-append">
                <button class="btn btn-outline-primary"><i class="glyphicon glyphicon-search"></i></button>
            </div>
            <div class="invalid-feedback">
                form pencarian kosong.
            </div>
        </div>
        </form>
    </div>
</div>



 <div class="card mt-2">
    <div class="card-header">
        Pesan
    </div>
    <ul class="list-group list-group-flush">
        <?php foreach ($teman as $item) { ?>
            <li class="list-group-item">
                <div class="mr-2" style="font-size:14px;float:left;">
                    <?php 
                        if (empty($item->foto)){
                            echo "<img class='rounded-circle' src='".base_url("uploads/kosong.jpg")."' width='50' />";
                        }else{
                            echo "<img class='rounded-circle' src='".base_url("uploads/" .$item->foto)."' width='50' />";
                        }
                    ?>
                </div>
                <div class="ml-5">
                    <a href="javascript:;" data-friend="<?php echo $item->user_id ?>"><?php echo $item->username ?> </a>
                    <a href="<?php echo site_url ('profil_member/profil/'. $item->user_id); ?>" class="btn btn-outline-info btn-sm float-right">Profil </a>   
                    <?php
                        $admin = $item->level =='admin';
                        if($item->user_id == $admin){
                            echo '<span class="badge badge-secondary">'.$item->level.'</span>';
                        }?>
                    <br>
                    
                    <span style="font-size:11px;"><?php echo $item->name ?></span>
                    <!-- <?php echo $item->message ?>  -->
                </div>
                     
            </li>
        <?php } ?> 
    </ul>
</div>

    
<!-- TEMPLATE -->
<div id="wgt-container-template" style="display: none">
    <div class="msg-wgt-container">
        <div class="msg-wgt-header">
            <a href="javascript:;" class="online"></a>
            <a href="javascript:;" class="name"></a>
            <a href="javascript:;" class="close">x</a>
        </div>
        <div class="msg-wgt-message-container">
            <table width="100%" class="msg-wgt-message-list">
            </table>
        </div>
        <div class="msg-wgt-message-form">
            <textarea name="message" placeholder="Type your message. Press Shift + Enter for newline"></textarea>
        </div>
    </div>
</div>
    
<script type="text/x-template" id="msg-template" style="display: none">
    <tbody class="pesan">
        <tr class="msg-wgt-message-list-header">
        <!-- <td rowspan="2"><img src="<?= base_url('uploads/kosong.jpg') ?>"></td> -->
            <td class="name"></td>
            <td class="time"></td>
        </tr>
        <tr class="msg-wgt-message-list-body">
            <td colspan="2"></td>
        </tr>
        <tr class="msg-wgt-message-list-separator"><td colspan="3"></td></tr>
    </tbody>
</script>
            

<script type="text/javascript">
jQuery(document).ready(function($) {
        var chatPosition = [
            false, // 1
            false, // 2
            false, // 3
            false, // 4
            false, // 5
            false, // 6
            false, // 7
            false, // 8
            false, // 9
            false // 10
        ];

    // New chat
    $(document).on('click', 'a[data-friend]', function(e) {
        var $data = $(this).data();
        if ($data.friend !== undefined && chatPosition.indexOf($data.friend) < 0) {
            var posRight = 0;
            var position;
            for(var i in chatPosition) {
                if (chatPosition[i] == false) {
                    posRight = (i * 270) + 20;
                    chatPosition[i] = $data.friend;
                    position = i;
                    break;
                }
            }
            var tpl = $('#wgt-container-template').html();
            var tplBody = $('<div/>').append(tpl);
            tplBody.find('.msg-wgt-container').addClass('msg-wgt-active');
            tplBody.find('.msg-wgt-container').css('right', posRight + 'px');
            tplBody.find('.msg-wgt-container').attr('data-chat-position', position);
            tplBody.find('.msg-wgt-container').attr('data-chat-with', $data.friend);
            $('body').append(tplBody.html());
            initializeChat();
        }
    });

    // Minimize Maximize
    $(document).on('click', '.msg-wgt-header > a.name', function() {
        var parent = $(this).parent().parent();
        if (parent.hasClass('minimize')) {
            parent.removeClass('minimize')
        } else {
            parent.addClass('minimize');
        }
    });

    // Close
    $(document).on('click', '.msg-wgt-header > a.close', function() {
        var parent = $(this).parent().parent();
        var $data = parent.data();
        parent.remove();
        chatPosition[$data.chatPosition] = false;
        setTimeout(function() {
            initializeChat();
        }, 1000)
    });

    var chatInterval = [];

    var initializeChat = function() {
        $.each(chatInterval, function(index, val) {
            clearInterval(chatInterval[index]);   
        });

        $('.msg-wgt-active').each(function(index, el) {
            var $data = $(this).data();
            var $that = $(this);
            var $container = $that.find('.msg-wgt-message-container');

            chatInterval.push(setInterval(function() {

                var oldscrollHeight = $container[0].scrollHeight;
                var oldLength = 0;
                $.post('<?php echo site_url('profil_member/getChats') ?>', {chatWith: $data.chatWith}, function(data, textStatus, xhr) {
                    $that.find('a.name').text(data.name);
                    // from last
                    var chatLength = data.chats.length;
                    var newIndex = data.chats.length;
                    $.each(data.chats, function(index, el) {
                        newIndex--;
                        var val = data.chats[newIndex];

                        var tpl = $('#msg-template').html();
                        var tplBody = $('<div/>').append(tpl);
                        var id = (val.chat_id +'_'+ val.send_by +'_'+ val.send_to).toString();
                        

                        if ($that.find('#'+ id).length == 0) {
                            tplBody.find('tbody').attr('id', id); // set class
                            tplBody.find('td.name').text(val.name); // set name
                            tplBody.find('td.time').text(val.time); // set time
                            tplBody.find('.msg-wgt-message-list-body > td').html(nl2br(val.message)); // set message
                            $that.find('.msg-wgt-message-list').append(tplBody.html()); // append message

                            //Auto-scroll
                            var newscrollHeight = $container[0].scrollHeight - 20; //Scroll height after the request
                            if (newIndex === 0) {
                                $container.animate({ scrollTop: newscrollHeight }, 'normal'); //Autoscroll to bottom of div
                            }
                        }
                    });
                });
            }, 1000));

            $that.find('textarea').on('keydown', function(e) {
                var $textArea = $(this);
                if (e.keyCode === 13 && e.shiftKey === false) {
                    $.post('<?php echo site_url('profil_member/sendMessage') ?>', {message: $textArea.val(), chatWith: $data.chatWith}, function(data, textStatus, xhr) {
                    });
                    $textArea.val(''); // clear input

                    e.preventDefault(); // stop 
                    return false;
                }
            });
        });
    }
    var nl2br = function(str, is_xhtml) {
        var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br ' + '/>' : '<br>'; // Adjust comment to avoid issue on phpjs.org display
        return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
    }

    // on load
    initializeChat();
});
</script>