<script type="text/javascript">
    tinymce.init({
        selector: '#myTextarea2',

        plugins: [
            'advlist autolink link image lists charmap print preview hr anchor pagebreak',
            'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking',
            'emoticons template paste help'
        ],

        toolbar: 'undo redo | bold italic | alignleft aligncenter alignright alignjustify | ' +
            ' |  | print preview fullpage | ' +
            'forecolor backcolor',
        menu: {
        },

        menubar: ' ',
        content_css: 'http://uniapanstw.pl/js/tinymce/css/content.css',

        max_chars: 5000, // max. allowed chars
        setup: function (ed) {
            var allowedKeys = [8, 37, 38, 39, 40, 46]; // backspace, delete and cursor keys
            ed.on('keydown', function (e) {
                if (allowedKeys.indexOf(e.keyCode) != -1) return true;
                if (tinymce_getContentLength() + 1 > this.settings.max_chars) {
                    e.preventDefault();
                    e.stopPropagation();
                    return false;
                }
                return true;
            });
            ed.on('keyup', function (e) {
                tinymce_updateCharCounter(this, tinymce_getContentLength());
            });
        },
        init_instance_callback: function () { // initialize counter div
            $('#' + this.id).prev().append('<div class="char_count" style="text-align:right"></div>');
            tinymce_updateCharCounter(this, tinymce_getContentLength());
        },
        paste_preprocess: function (plugin, args) {
            var editor = tinymce.get(tinymce.activeEditor.id);
            var len = editor.contentDocument.body.innerText.length;
            var text = $(args.content).text();
            if (len + text.length > editor.settings.max_chars) {
                alert('Pasting this exceeds the maximum allowed number of ' + editor.settings.max_chars + ' characters.');
                args.content = '';
            } else {
                tinymce_updateCharCounter(editor, len + text.length);
            }
        }
    });
    function tinymce_updateCharCounter(el, len) {
        $('#' + el.id).prev().find('.char_count').text(len + '/' + el.settings.max_chars);
    }

    function tinymce_getContentLength() {
        return tinymce.get(tinymce.activeEditor.id).contentDocument.body.innerText.length;
    }
</script><?php


echo ' <div class="main">
    <div class="content"> <div class="card">
<div class="w3-container w3-teal">
  <h2><br>Edycja danych profilu mieszkańca</h2>
</div>';
if (isset($_POST['name'])){
    $max_rozmiar = 1024*1024;
    if (is_uploaded_file($_FILES['plik']['tmp_name'])) {
        if ($_FILES['plik']['size'] > $max_rozmiar) {
            echo 'Błąd! Plik jest za duży!';
        } else {
            $file_ext=strtolower(end(explode('.',$_FILES['plik']['name'])));
            $_FILES['plik']['name'] = 'avatar_'.$_COOKIE['id'].'.'.$file_ext;
            $file_name_sql = $_FILES['plik']['name'];

            echo '<br/>';
            if (isset($_FILES['plik']['type'])) {

            }
            move_uploaded_file($_FILES['plik']['tmp_name'],'user_gfx/'.$_FILES['plik']['name']);
        }
    }
    echo '<p>Dane zostały zmienione pomyślnie</p><br>';
    $user->setName($_POST['name']);
    if($_POST['password']!='') $user->setPassword($_POST['password']);
    $user->setEmail($_POST['email']);
    $text = nl2br($_POST['text'],false);
    $user->setText($text);
    $url_awatar = _URL.'/user_gfx/'.$file_name_sql;
    if($file_name_sql!='') $user->setAvatarUrl($url_awatar);
} else {
    echo'<form class="w3-container" method="post" ENCTYPE="multipart/form-data">
  <label class="w3-text-teal"><b>Imie i nazwisko </b></label><br>
  <input class="w3-input w3-border w3-light-grey" type="text" style="width: 350px" name="name" value="'.$user->getName().'"><br>
  
  <label class="w3-text-teal"><b>Hasło </b></label><br>
  <input class="w3-input w3-border w3-light-grey" type="password" style="width: 350px" name="password""><br>
  
  <label class="w3-text-teal"><b>Treść profilu...</b></label><br>
  <textarea id="myTextarea2" name="text" class="w3-input w3-border w3-light-grey" rows="4" cols="150">'.$user->getText().'</textarea><br>
  
  
  <label class="w3-text-teal"><b>Email </b></label><br>
  <input class="w3-input w3-border w3-light-grey" type="text" style="width: 350px" name="email"  value="'.$user->getEmail().'"><br>
 
  <label class="w3-text-teal"><b>Wgraj avatar (proporcje 1:1 - 100x100, 200x200 itd)</b></label><br>
  <input type="file" class="custom-file-input"  name="plik" multiple="">
  <p> </p>
  <button class="w3-btn w3-blue-grey">Dokonaj edycji</button>
</form>';
}
echo'</div></div>';
