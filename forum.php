<?php
/**
 * @param $search_string
 * @param $array
 * @return false|int|string
 */
function multiArraySearch($search_string, $array){
    $value = false;
    $x = 0;
    foreach($array as $temp){
        $search = array_search($search_string, $temp);
        if (strlen($search) > 0 && $search >= 0){
            return $value[1] = $search;
        }
        $x++;
    }
    return $value;
}
$url = 'https://forum.uniapanstw.pl/api/categories';

//  Initiate curl
$ch = curl_init();
// Will return the response, if false it print the response
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// Set the url
curl_setopt($ch, CURLOPT_URL, $url);
// Execute
$result = curl_exec($ch);
// Closing
curl_close($ch);

// Will dump a beauty json :3
$xx = json_decode($result, true);

//print_r ($xx);
//echo '<BR><BR><BR><BR><BR><BR>';
$cnt = count($xx['categories']);
$table=[];
for ($x = 0; $x < $cnt; $x++) {
//    echo '<br>Kategorie główne ('.$xx[categories][$x][cid].')'.$xx[categories][$x][name].'<br>';
    $cnt1 = count($xx['categories'][$x]['children']);
    for ($xy = 0; $xy < $cnt1; $xy++) {
//        echo '&nbsp;&nbsp;&nbsp;&nbsp;-Kategorie średnie ('.$xx[categories][$x][children][$xy][cid].')'.$xx[categories][$x][children][$xy][name].'<br>';
        $table[] =[
            $xx['categories'][$x]['name'] => $xx['categories'][$x]['children'][$xy]['cid'],
            'nazwa' => $xx['categories'][$x]['children'][$xy]['name'],
            'cid_g' => $xx['categories'][$x]['cid'],
            'nazwa_g' => $xx['categories'][$x]['name'],
        ];

    }

}

$url = 'https://forum.uniapanstw.pl/api/recent';

//  Initiate curl
$ch = curl_init();
// Will return the response, if false it print the response
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// Set the url
curl_setopt($ch, CURLOPT_URL, $url);
// Execute
$result = curl_exec($ch);
// Closing
curl_close($ch);

// Will dump a beauty json :3
$xx = json_decode($result, true);

//print_r ($xx);
//echo '<BR><BR><BR><BR><BR><BR>';
$cnt = count($xx['topics']);

for ($x = 0; $x < 6; $x++) {

//    print_r ($xx[topics][$x]);
//    echo '<br><br>';
//    echo 'Tytuł <b>' . $xx[topics][$x][titleRaw] . '</b><br>';
//    echo 'Ilosc odpowiedzi <b>' . $xx[topics][$x][postcount] . '</b><br>';
    $wynik = multiArraySearch($xx['topics'][$x]['cid'], $table);
    echo'                <tr>
                    <td><a href="https://forum.uniapanstw.pl/topic/'.$xx['topics'][$x]['slug'].'" style="text-decoration: none; color: #1d4e85">' . $xx['topics'][$x]['titleRaw'] . '</a</td>
                    <td>('.$xx['topics'][$x]['postcount'].') #'.$wynik.'</td>
                </tr>';

}