<meta name="viewport" content="width=device-width, initial-scale=0.6"/>
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
        menu: {},
        paste_preprocess: function (plugin, args) {
            console.log("Attempted to paste: ", args.content);
            // replace copied text with empty string
            args.content = '';
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
</script>
<style>
    a {
        text-decoration: none;
        color: #1d4e85;
    }

    .alert {
        padding: 20px;
        background-color: #f44336;
        color: white;
        opacity: 1;
        transition: opacity 0.6s;
        margin-bottom: 15px;
    }

    .alert.success {
        background-color: #4CAF50;
    }

    .alert.info {
        background-color: #2196F3;
    }

    .alert.warning {
        background-color: #ff9800;
    }

    .profile-imgp {
        width: 75px;
        height: 75px;
        border-radius: 1000px;
        position: center;

        border: 6px solid #fff;
        -webkit-box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
    }

    .closebtn {
        margin-left: 15px;
        color: white;
        font-weight: bold;
        float: right;
        font-size: 22px;
        line-height: 20px;
        cursor: pointer;
        transition: 0.3s;
    }

    .closebtn:hover {
        color: black;
    }</style>
<style>
    img {
        max-width: 80%;
        height: auto;
    }
</style><?php
$id = $_COOKIE['id'];
$article = System::getMediaArcitleInfo($_GET['typ']);
?>

<div class="hero">
    <div class="hero-content">
        <h2>Media</h2>
        <hr width="800"/>
        <p>
            <?php echo $article['title']; ?><br> &nbsp;
        </p>
    </div>
    <div class="hero-content-mobile"><h2>Media</h2></div>
</div>
<?php
$tant = System::config_info();
$conn = pdo_connect_mysql_up();
$sql = "SELECT COUNT(*) FROM `up_media_article_like` WHERE article_id = '$_GET[typ]' AND user_id = '$_COOKIE[id]'";
$stmt = $conn->query($sql)->fetch(PDO::FETCH_NUM);
if ($_GET['ptyp'] == 'LIKE' and $stmt[0] == '0') {
    Create::Like($_GET['typ'], $_COOKIE['id'], '1');
    $article = System::getMediaArcitleInfo($_GET['typ']);
    $org_info = System::organization_info($article['organizations_id']);
    $tantiema = $tant['coment_tantiem'] / 2;
    $salary = ($org_info['article_salary_user'] == '') ? '0' : $org_info['article_salary_user'];
    $percentForAuthor = ($salary / 100);
    $tantiema_dla_org = ($tantiema * (1 - $percentForAuthor));
    $tantiema_dla_aut = ($tantiema * $percentForAuthor);
    $title = 'Tantiema za polubienie artykułu ' . $article['title'];
    $conn = pdo_connect_mysql_up();
    $sql12 = "SELECT * FROM `bank_account` WHERE owner_id = '$article[users_id]'  LIMIT 0,1";
    $sth12 = $conn->query($sql12);
    $licznik = 0;
    while ($row12 = $sth12->fetch()) {
        $bank_to = $row12['id'];
    }
    $sql1 = "SELECT * FROM `bank_account` WHERE owner_id = '$article[organizations_id]'";
    $sth1 = $conn->query($sql1);
    $licznik = 0;
    while ($row1 = $sth1->fetch()) {

        $bank_from = $row1['id'];
    }
    $bank_acc = ($org_info['main_bank_acc']=='')? $bank_from : $org_info['main_bank_acc'];
    if ($tantiema_dla_aut != 0) Bank::transfer(_TANTIEMAKOMENTARZ, $bank_acc, $tantiema_dla_aut, $title);
    $sum = Bank::transfer(_TANTIEMAKOMENTARZ, $bank_acc, $tantiema_dla_org, $title);
    $new_value = ($article['dotation_counter'] + $tantiema);
    if ($sum == 'OK') update('up_media_article', 'id', $_GET['typ'], 'dotation_counter', $new_value);
    header('Location: ' . _URL . '/media/' . $_GET['typ']);
} else if ($_GET['ptyp'] == 'DISLIKE' and $stmt[0] == '0') {
    Create::Like($_GET['typ'], $_COOKIE['id'], '2');
    header('Location: ' . _URL . '/media/' . $_GET['typ']);
}
if (isset($_POST['text_comment'])) {
    $article = System::getMediaArcitleInfo($_GET['typ']);
    $org_info = System::organization_info($article['organizations_id']);
    $text = str_replace('<p>&nbsp;</p>', ' ', $_POST['text_comment']);
    Create::MediaArticleComment($_COOKIE['id'], $_GET['typ'], $text);
    $url = _URL;
    if (strlen($text) < 500) $tantiema = $tant['coment_tantiem']; else $tantiema = ($tant['coment_tantiem'] * 2);
    $salary = ($org_info['article_salary_user'] == '') ? '0' : $org_info['article_salary_user'];
    $percentForAuthor = ($salary / 100);
    $tantiema_dla_org = ($tantiema * (1 - $percentForAuthor));
    $tantiema_dla_aut = ($tantiema * $percentForAuthor);
    $title = 'Tantiema za komentarz do artykułu ' . $article['title'];
    $conn = pdo_connect_mysql_up();
    $sql12 = "SELECT * FROM `bank_account` WHERE owner_id = '$article[users_id]'  LIMIT 0,1";
    $sth12 = $conn->query($sql12);
    $licznik = 0;
    while ($row12 = $sth12->fetch()) {
        $bank_to = $row12['id'];
    }
    $sql1 = "SELECT * FROM `bank_account` WHERE owner_id = '$article[organizations_id]'";
    $sth1 = $conn->query($sql1);
    $licznik = 0;
    while ($row1 = $sth1->fetch()) {

        $bank_from = $row1['id'];
    }
    $bank_acc = ($org_info['main_bank_acc']=='')? $bank_from : $org_info['main_bank_acc'];
    if ($tantiema_dla_aut != 0) Bank::transfer(_TANTIEMAKOMENTARZ, $bank_to, $tantiema_dla_aut, $title);
    $sum = Bank::transfer(_TANTIEMAKOMENTARZ, $bank_acc, $tantiema_dla_org, $title);
    $new_value = ($article['dotation_counter'] + $tantiema);
    if ($sum == 'OK') update('up_media_article', 'id', $_GET['typ'], 'dotation_counter', $new_value);

    header("Location: $url/media/$_GET[typ]/COM_OK/$sum");
}
if ($_GET['ptyp'] == 'dotation') {
    $article = System::getMediaArcitleInfo($_GET['typ']);
    $org_info = System::organization_info($article['organizations_id']);
    $title = 'Dotacja artykułu: ' . $article['title'] . ', kwota ' . $_POST['value'];
    $salary = ($org_info['article_salary_user'] == '') ? '0' : $org_info['article_salary_user'];
    $percent = ($salary / 100);
    $tantiema_dla_org = ($_POST['value'] * (1 - $percent));
    $tantiema_dla_aut = ($_POST['value'] * $percent);

    $sql12 = "SELECT * FROM `bank_account` WHERE owner_id = '$article[users_id]'  LIMIT 0,1";
    $sth12 = $conn->query($sql12);
    $licznik = 0;
    while ($row12 = $sth12->fetch()) {
        $bank_to = $row12['id'];
    }
    if ($tantiema_dla_aut != 0) Bank::transfer($_POST['acc'], $bank_to, $tantiema_dla_aut, $title);
    $sum = Bank::transfer($_POST['acc'], $org_info['main_bank_acc'], $tantiema_dla_org, $title);
    $new_value = ($article['dotation_counter'] + $_POST['value']);
    if ($sum == 'OK') update('up_media_article', 'id', $_GET['typ'], 'dotation_counter', $new_value);
    $url = _URL;
    $title = 'Wpłacono dotacje za art. nr: ' . $_GET['typ'] . ' tytuł <b>' . $article['title'] . '</b> w kwocie: ' . $tantiema_dla_org . ' kr';
    Create::Alert($article['users_id'], $title);
    header("Location: $url/media/$_GET[typ]/$sum");
}
if ($_COOKIE['id'] != '' and $_COOKIE['id'] != $article['users_id']) $like = '<a href="' . _URL . '/media/' . $_GET['typ'] . '/LIKE"><span class="material-icons" style="color: green">thumb_up</span></a><a href="' . _URL . '/media/' . $_GET['typ'] . '/DISLIKE"><span class="material-icons" style="color: red">thumb_down</span></a>';
$sql123 = "SELECT * FROM `up_media_article_like` WHERE article_id = '$article[id]' AND user_id='$_COOKIE[id]' LIMIT 0,1";
$sth123 = $conn->query($sql123);
while ($row123 = $sth123->fetch()) {
    $like = ($row123['like'] == 1) ? '<span class="material-icons" style="color: green">thumb_up</span>' : '<span class="material-icons" style="color: red">thumb_down</span>';
}


?>

<div class="main">
    <div class="content">
        <div class="card"><?
            $info = System::getMediaArcitleInfo($_GET['typ']);
            $author = System::getInfo($info['users_id']);
            $org = System::getInfo($info['organizations_id']);


            if (isset($_GET['typ'])) {
                echo '<br><table width="90%" align="center" >
    <tr>
        <td width="40%" align="left" style="border-bottom-width:1px; border-bottom-color:rgb(51,51,51); border-bottom-style:solid;"><a href="' . _URL . '/profil/' . $org['id'] . '">' . $org['name'] . '</a> &nbsp;&nbsp;&nbsp; ' . timeToDateTime($info['data']) . '<br><sup><a href="' . _URL . '/profil/' . $author['id'] . '">' . $author['name'] . '</a></sup></td>
        <td width="60%" style="border-bottom-width:1px; border-bottom-color:rgb(51,51,51); border-bottom-style:solid;"><b>' . $info['title'] . '</b></td>
        <td width="5%" style="border-bottom-width:1px; border-bottom-color:rgb(51,51,51); border-bottom-style:solid;"><b>' . $like . ' </b></td>
    </tr>
    <tr>
        <td width="80%" colspan="2" align="left" style="border-bottom-width:1px; border-bottom-color:rgb(51,51,51); border-bottom-style:solid;"><p>' . $info['text'] . '</p></td>
    </tr>
    <tr>';
                if ($_COOKIE['id'] != '') {
                    echo '<td width="100%" colspan="2"><p>DOTUJ ARTYKUŁ</p><form action="' . _URL . '/media/' . $_GET['typ'] . '/dotation" method="post">
            <select name="acc" style="width: 180px;">';

                    $conn = pdo_connect_mysql_up();
                    $sql = "SELECT * FROM `bank_account` WHERE owner_id = '$_COOKIE[id]'";
                    $sth = $conn->query($sql);
                    while ($row = $sth->fetch()) {
                        echo '<option value="' . $row['id'] . '">Rachunek nr: #' . $row['id'] . '</option>';
                    }
                    echo '</select> &nbsp;&nbsp;&nbsp; <select name="value" style="width: 100px;"> 
                        <option value="100">100 kr</option>
                        <option value="250">250 kr</option>
                        <option value="500">500 kr</option>
                        <option value="1000">1000 kr</option>
                        <option value="2500">2500 kr</option>
                        <option value="5000">5000 kr</option>
                    </select> &nbsp; <button style="width: 100px;">DOTUJ</button> </form> ';


                    if ($_GET['ptyp'] == 'OK') {
                        echo '
    <div class="alert info">  <span class="closebtn" onclick="this.parentElement.style.display=none;">&times;</span>DOTACJA ZOSTAŁA PRZEKAZANA ORGANIZACJI
</div>';
                    } else if ($_GET['ptyp'] == 'MONEY') {
                        echo '
    <div class="alert warning">  <span class="closebtn" onclick="this.parentElement.style.display=none;">&times;</span>BRAK ŚRODKÓW NA KONCIE
</div>';
                    }
                    $article = System::getMediaArcitleInfo($_GET['typ']);
                    $org_info = System::organization_info($article['organizations_id']);
                    $salary = ($org_info['article_salary_user'] == '') ? '0' : $org_info['article_salary_user'];
                    echo '</td></tr>    <tr>
        <td width="100%" colspan="2" align="right"><sub>Zebrano: ' . $info['dotation_counter'] . ' kr  (' . ($salary) . '% dla autora)</sub></td>
    </tr>';
                } else echo '<TR><TD WIDTH="100%" COLSPAN="2">
    <div class="alert info">  <span class="closebtn" onclick="this.parentElement.style.display=none;">&times;</span>ZALOGUJ SIĘ ABY DODAĆ KOMENTARZ LUB DOTOWAĆ MATERIAŁ
</div></TD></TR>';

                echo '
    <tr>
        <td width="100%" colspan="2" align="center"><HR>';
                if ($_COOKIE['id'] != '') {
                    echo '<form class="w3-container" method="post" ENCTYPE="multipart/form-data">
          
        <textarea id="myTextarea2" name="text_comment" class="w3-input w3-border w3-light-grey" style="width: 80%;"> </textarea><br>
        <button class="w3-btn w3-blue-grey" style="width: 80%;">Dodaj komentarz</button>
        </form><hr>';
                }
                if ($_GET['ptyp'] == 'COM_OK') {
                    echo '
    <div class="alert info">  <span class="closebtn" onclick="this.parentElement.style.display=none;">&times;</span>KOMENTARZ ZOSTAŁ DODANY
</div>';
                }
                echo '</td>
    </tr>
    <tr>
        <td width="100%" colspan="2">';
                $conn = pdo_connect_mysql_up();
                $sql = "SELECT * FROM `up_media_article_coment` WHERE article_id = '$info[id]' ORDER BY `date` ";
                $sth = $conn->query($sql);
                while ($row = $sth->fetch()) {
                    $author_com = System::user_info($row['user_id']);

                    echo '<table width="100%" cellpadding="0" cellspacing="0" align="center">
    <tr>
        <td width="15%" rowspan="2" align="center" valign="top"><a href="' . _URL . '/profil/' . $author_com['id'] . '" style="text-decoration: none; color: #1d4e85"><img src="' . $author_com['avatar_url'] . '" alt="Zdjęcie profilowe" class="profile-imgp"></a></td>
        <td width="85%" align="left"><a href="' . _URL . '/profil/' . $author_com['id'] . '" style="text-decoration: none; color: #1d4e85">' . $author_com['name'] . '</a><br> <sup>' . timeToDateTime($row['date']) . '</sup></td>
    </tr>
    <tr>
        <td width="100%"  align="left" style="border-bottom-width:1px; border-bottom-style:solid;">' . $row['text'] . '</td>
    </tr>
</table><br>';
                }
                echo '<hr><table width="100%" cellpadding="0" cellspacing="0" align="center">
    <tr>
        <td width="10%" align="center" valign="top"><span class="material-icons" style="color: green">thumb_up</span></td>
       <td width="90%" align="left" style="font-size: 13px">';

                $sql1 = "SELECT * FROM `up_media_article_like` WHERE article_id = '$info[id]' AND `like`='1' ORDER BY `time` ";
                $sth1 = $conn->query($sql1);
                while ($row1 = $sth1->fetch()) {
                    $name = System::user_info($row1['user_id']);
                    echo '<a href="' . _URL . '/profil/' . $name['id'] . '">' . $name['name'] . '</a>, ';
                }
                echo '</td>
    </tr>
</table><br><table width="100%" cellpadding="0" cellspacing="0" align="center">
    <tr>
        <td width="10%" align="center" valign="top"><span class="material-icons" style="color: red">thumb_down</span></td>
       <td width="90%" align="left" style="font-size: 13px">';
                $sql1 = "SELECT * FROM `up_media_article_like` WHERE article_id = '$info[id]' AND `like`='2' ORDER BY `time` ";
                $sth1 = $conn->query($sql1);
                while ($row1 = $sth1->fetch()) {
                    $name = System::user_info($row1['user_id']);
                    echo '<a href="' . _URL . '/profil/' . $name['id'] . '">' . $name['name'] . '</a>, ';
                }

                echo '</td>
    </tr>
</table><br></td>
    </tr> 
 
</table>';
            } else {
                echo ' <h3>Archiwum artykułów</h3><table width="95%" align="center">';
                $conn = pdo_connect_mysql_up();
                $sql = "SELECT * FROM `up_media_article` WHERE `opt`=0 ORDER BY `data` DESC";
                $sth = $conn->query($sql);
                while ($row = $sth->fetch()) {
                    $info = System::getInfo($row['organizations_id']);
                    $count = System::getMediaArcitleComment($row['id']);
                    echo '
           
                         <tr>
                            <td width="65%" style="max-height: 5px; font-family: Verdana, Geneva, Tahoma, sans-serif;  font-style: bold;   font-size: 11px;" align="left">
                <b><a href="' . _URL . '/media/' . $row['id'] . '" style="text-decoration: none; color: #1d4e85">' . $row['title'] . '</a></b></td>
                            <td width="5%" style="max-height: 5px">
                            <div class="artykul_feed">
                    <div class="comments">
                    <div class="material-iconss">
                        <i class="material-icons" >mode_comment</i>
                        <span class="count" style="font-size: 14px; margin-left: -5px">' . $count . '</span>
                    </div></div>
                </div>
                </td>
                            <td width="30%" style="max-height: 5px" align="center"><div class="artykul_feed">
                            <div class="gazeta"><span class="badge"> ' . substr($info['name'], 0, 30) . ' </span></div></div></td>
                        </tr>
            ';
                }
                echo '</table>';
            }

            ?></div>
    </div>
    <div class="menu">

        <div class="card menucard sticky">
            <p class=""><a href="<?php echo _URL; ?>/organizacje"
                           style="text-decoration: none; color: black;">Organizacje</a></a></p>
            <p class=""><a href="<?php echo _URL; ?>/kraje"
                           style="text-decoration: none; color: black;">Kraje</a></p>
            <p class=""><a href="<?php echo _URL; ?>/mieszkancy"
                           style="text-decoration: none; color: black;">Mieszkancy</a></p>


        </div>

    </div>
</div>
