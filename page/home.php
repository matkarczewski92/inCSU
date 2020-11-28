<?php

if ($error_page_no == 1) echo 'cos';

?>

<div class="hero">
    <div class="hero-content">
        <h2>Kraina spełnienia</h2>
        <hr width="800"/>
        <p>
            Miejsce, w którym każdy osiągnie wszystko<br>gdy tylko będzie tego chcieć
        </p>
        <?php
        $vote = System::ActiveVote($_COOKIE['id']);
        $vote_name = 'głosowań';
        if ($vote == '1') $vote_name = 'głosowanie';
        if ($vote == '2' AND $vote == '3' AND $vote == '4') $vote_name = 'głosowania';


        echo ($vote != 0 AND $_COOKIE['id']!='') ? '<form action="'._URL.'/probe"> <button href="#" style="background-color: #008CBA">Na Twój głos czeka <u>'.$vote.'</u> '.$vote_name.'</button></form>' : '';
        echo ($_COOKIE['id'] == '') ? '<button href="#" onclick="document.getElementById(\'id01\').style.display=\'block\'">Nie masz konta - ZAREJESTRUJ SIE</button>' : '';
        echo ($_COOKIE['id'] == '') ? '<center><span class="material-icons dropbtn" onclick="myFunction()" style="width: 100%"><button href="#about">LOGOWANIE</button></span></center>' : '';
        ?>  </div>
    <div class="hero-content-mobile"><h2>Kraina spełnienia</h2></div>
</div>

<div class="main">
    <?php
    $big_art = System::getMediaRotator();
    $big_art_info = System::getMediaArcitleInfo($big_art['article_id']);
    $big_art_info_auth = System::getInfo($big_art_info['organizations_id']);
//
    do {
    $mid_art = System::getMediaRotator();
    $mid_art_info = System::getMediaArcitleInfo($mid_art['article_id']);
    $mid_art_info_auth = System::getInfo($mid_art_info['organizations_id']);
    } while ($mid_art_info['id']==$big_art_info['id']);
//
    do {
    $small_art1 = System::getMediaRotator();
    $small_art1_info = System::getMediaArcitleInfo($small_art1['article_id']);
    $small_art1_info_auth = System::getInfo($small_art1_info['organizations_id']);
    } while ($small_art1_info['id']==$big_art_info['id'] OR $small_art1_info['id']==$mid_art_info['id']);
//
    do {
        $small_art2 = System::getMediaRotator();
        $small_art2_info = System::getMediaArcitleInfo($small_art2['article_id']);
        $small_art2_info_auth = System::getInfo($small_art2_info['organizations_id']);
    } while ($small_art2_info['id']==$big_art_info['id'] OR $small_art2_info['id']==$mid_art_info['id'] OR $small_art2_info['id']==$small_art1_info['id']);

    echo '  <div class="bigart" style="background-image: url(' . $big_art['gfx_url'] . ');">
        <div class="big_art">
            <p><a href="'._URL.'/media/'.$big_art_info['id'].'" style="text-decoration: none; color: white">' . $big_art_info_auth['name'] . '</a></p>
            <h2><a href="'._URL.'/media/'.$big_art_info['id'].'" style="text-decoration: none; color: white">' . $big_art_info['title'] . '<br>
            <p style="font-size: 10px">(Kliknij aby przeczytać)</p></a></h2>
        </div>
    </div>
    <div class="mdmart" style=" background-image: url(' . $mid_art['gfx_url'] . ');">
        <div class="mdm_art">
            <p><a href="'._URL.'/media/'.$mid_art_info['id'].'" style="text-decoration: none; color: white">' . $mid_art_info_auth['name'] . '</a></p>
            <h2><a href="'._URL.'/media/'.$mid_art_info['id'].'" style="text-decoration: none; color: white">' . $mid_art_info['title'] . '</a></h2>
        </div>
    </div>
    <div class="smllart_01" style="background-image: url(' . $small_art1['gfx_url'] . ');">
        <div class="small01_art">
            <p><a href="'._URL.'/media/'.$small_art1_info['id'].'" style="text-decoration: none; color: white">' . $small_art1_info_auth['name'] . '</a></p>
            <h3><a href="'._URL.'/media/'.$small_art1_info['id'].'" style="text-decoration: none; color: white">' . $small_art1_info['title'] . '</a></h3>
        </div>
    </div>
    <div class="smllart_02" style="background-image: url(' . $small_art2['gfx_url'] . ');">
        <div class="small02_art">
            <p><a href="'._URL.'/media/'.$small_art2_info['id'].'" style="text-decoration: none; color: white">' . $small_art2_info_auth['name'] . '</a></p>
            <h3><a href="'._URL.'/media/'.$small_art2_info['id'].'" style="text-decoration: none; color: white">' . $small_art2_info['title'] . '</a></h3>
        </div>
    </div>
';
    ?>

    <div class="prasa">
        <h3>Prasa</h3>
        <hr width="100" class="rounded" align="left"/>
        <div class="prasa_feed">


            <table width="95%" align="center">
                <?php
                $conn = pdo_connect_mysql_up();
                $sql = "SELECT * FROM `up_media_article` WHERE `opt`=0 ORDER BY `data` DESC LIMIT 0,8";
                $sth = $conn->query($sql);
                while ($row = $sth->fetch()) {
                    $info = System::getInfo($row['organizations_id']);
                    $count = System::getMediaArcitleComment($row['id']);
                    echo '
                     
                         <tr>
                            <td width="65%" style="max-height: 5px; font-family: Verdana, Geneva, Tahoma, sans-serif;  font-style: bold;   font-size: 11px;">
                <b><a href="' . _URL . '/media/' . $row['id'] . '" style="text-decoration: none; color: #1d4e85">' . substr($row['title'], 0, 60) . ' ...</a></b></td>
                            <td width="5%" style="max-height: 5px">
                            <div class="artykul_feed">
                    <div class="comments">
                    <div class="material-iconss">
                        <i class="material-icons">mode_comment</i>
                        <span class="count">' . $count . '</span>
                    </div></div>
                </div>
                </td>
                            <td width="30%" style="max-height: 5px" align="center"><div class="artykul_feed">
                            <div class="gazeta"><span class="badge"> ' . substr($info['name'], 0, 30) . ' </span></div></div></td>
                        </tr>
            ';
                }
                ?> <tr>
                    <td width="100%" style="max-height: 5px; font-family: Verdana, Geneva, Tahoma, sans-serif;  font-style: bold;   font-size: 11px;" COLSPAN="3" ALIGN="CENTER"><h5><a href="<? echo _URL.'/media'; ?>">ZOBACZ STARSZE ARTYKUŁY</a></h5></td>

                </tr>  </table>
        </div>
    </div>


    <div class="instytucje">
        <h3>Instytucje</h3>
        <hr width="100" class="rounded" align="left"/>
        <div class="row">
            <div class="column">
                <div class="card">
                    <div class="inst_label">
                        <h5>Dom Mody w Auterrze</h5>
                    </div>
                </div>
            </div>
            <div class="column">
                <div class="card">
                    <div class="inst_label">
                        <h5>Giełda Papierów Wartościowych</h5>
                    </div>
                </div>
            </div>
            <div class="column">
                <div class="card">
                    <div class="inst_label">
                        <h5>Teatr Unijny <br> im. Towarzysza Zenka</h5>
                    </div>
                </div>
            </div>
            <div class="column">
                <div class="card">
                    <div class="inst_label">
                        <h5>Zajazd u TomBonda</h5>
                    </div>
                </div>
            </div>
            <div class="column">
                <div class="card">
                    <div class="inst_label">
                        <h5>System Gospodarczy <br> Złoty Róg</h5>
                    </div>
                </div>
            </div>
            <div class="column">
                <div class="card">
                    <div class="inst_label">
                        <h5>Dyskoteka Almerska</h5>
                    </div>
                </div>
            </div>
            <div class="column">
                <div class="card">
                    <div class="inst_label">
                        <h5>Dyskoteka Almerska</h5>
                    </div>
                </div>
            </div>
            <div class="column">
                <div class="card">
                    <div class="inst_label">
                        <h5>Dyskoteka Almerska</h5>
                    </div>
                </div>
            </div>


        </div>
    </div>
    <div class="forum">

        <h3>Forum</h3>
        <hr width="100" class="rounded" align="left"/>
        <div class="forum_feed">
            <table>
                <?php
                require_once('forum.php');
                ?>
                </tr>
                <!--                <tr>-->
                <!--                    <td>Nastał czas... [nowa strona Teutonii]</td>-->
                <!--                    <td>#Życie Teutonii</td>-->
                <!--                </tr>-->
                <!--                <tr>-->
                <!--                    <td>dzień dobry</td>-->
                <!--                    <td>#Dyskusje Unijne</td>-->
                <!--                </tr>-->
                <!--                <tr>-->
                <!--                    <td>Wieści z zagranicy</td>-->
                <!--                    <td>#Plac Konfederacki</td>-->
                <!--                </tr>-->
                <!--                <tr>-->
                <!--                    <td>Wieści z zagranicy</td>-->
                <!--                    <td>#Plac Konfederacki</td>-->
                <!--                </tr>-->
                <!--                <tr>-->
                <!--                    <td>Wieści z zagranicy</td>-->
                <!--                    <td>#Plac Konfederacki</td>-->
                <!--                </tr>-->
                <!--                <tr>-->
                <!--                    <td>Wieści z zagranicy</td>-->
                <!--                    <td>#Plac Konfederacki</td>-->
                <!--                </tr>-->
                <!--                <tr>-->
                <!--                    <td>Wieści z zagranicy</td>-->
                <!--                    <td>#Plac Konfederacki</td>-->
                <!--                </tr>-->
                <!--                <tr>-->
                <!--                    <td>Wieści z zagranicy</td>-->
                <!--                    <td>#Plac Konfederacki</td>-->
                <!--                </tr>-->


            </table>
        </div>

    </div>

    <div class="prawo">

        <h3>Prawo</h3>
        <hr width="100" class="rounded" align="left"/>
        <div class="prawo_feed">
            <table>
                <?php
                $conn = pdo_connect_mysql_up();
                $sql = "SELECT * FROM `law_article` ORDER BY `date` DESC LIMIT 0,9";
                $sth = $conn->query($sql);
                while ($row = $sth->fetch()) {
                    $state = System::land_info($row['state_id']);
                    echo '                <tr>
                    <td><a href="' . _URL . '/prawo/pokaz/' . $row['id'] . '" style="text-decoration: none; color: #1d4e85">
        ' . $row['name'] . '</b> z dnia ' . timeToDate($row['date']) . '</a></td>
                    <td>#' . $state['name'] . '</td>
                </tr>';
                }
                ?>
            </table>
        </div>

    </div>

    <div class="panstwa-czlonkowskie">
        <div class="title">
            <h2>Państwa Członkowskie Unii</h2>
            <hr width="350" class="rounded" align="left"/>
        </div>
        <div class="countries">
            <div class="barr"><h3>Republika Baridas</h3>
                <img src="img/baridas.png" alt="Flaga Baridasu" class="bar"></div>
            <div class="dreamm"><h3>Królestwo Dreamlandu</h3>
                <img src="img/dreamland.png" alt="" class="dream"></div>
            <div class="scll"><h3>Konfederacja Sclavińska</h3>
                <img src="img/Flaga_Sclavinii.png" alt="" class="scl"></div>
            <div class="teutt"><h3>Cesarstwo Teutonii</h3>
                <img src="img/teutonia.png" class="teut" alt=""></div>
        </div>
    </div>
    <div class="czat">
        <div class="title">
            <h2>Odwiedź nasz kanał Discord!</h2>
            <hr width="500" class="rounded" align="left"/>
            <div class="chatbox">
                <iframe src="https://discordapp.com/widget?id=764130552554717214&theme=dark" width="300" height="500"
                        frameborder="0" sandbox="allow-popups allow-popups-to-escape-sandbox
      allow-same-origin allow-scripts"></iframe>
                <widgetbot
                        server="764130552554717214"
                        channel="769592394026057789"
                        width="1000"
                        height="500"
                ></widgetbot>
                <script src="https://cdn.jsdelivr.net/npm/@widgetbot/html-embed"></script>
            </div>
        </div>
    </div>
