<?php
require_once("../_functions.php");
require_once("../_check_for_admin.php");
require_once("../_mark_activity.php");
require_once('../PHPWord/vendor/autoload.php');
use PhpOffice\PhpWord\Shared\Converter;
//------------------------------------------------------------------------------------------------------//
$font_size = 10;
$tr_space = 20;
$space_exact = array('line' => 200, 'rule' => 'exact');
$space_exact_zero = array('line' => 60, 'rule' => 'exact');
//------------------------------------------------------------------------------------------------------//
$doc = new \PhpOffice\PhpWord\PhpWord();
$doc->setDefaultFontName("Times New Roman");
$doc->setDefaultFontSize($font_size);
$doc->setDefaultParagraphStyle(
    array(
        'spaceAfter' => Converter::pointToTwip(0),
        'spacing' => 120,
        'lineHeight' => 1
    )
);
//------------------------------------------------------------------------------------------------------//
/*$properties = $doc->getDocInfo();
$properties->setCreator('My name1');
$properties->setCompany('My factory1');
$properties->setTitle('My title1');
$properties->setDescription('My description1');
$properties->setCategory('My category1');
$properties->setLastModifiedBy('My name1');
$properties->setCreated(mktime(0, 0, 0, 3, 12, 2014));
$properties->setModified(mktime(0, 0, 0, 3, 14, 2014));
$properties->setSubject('My subject1');
$properties->setKeywords('my, key, word1');*/
//------------------------------------------------------------------------------------------------------//
if(1) {
    $id_eksperttest_doc = check_number($_GET['id_eksperttest_doc']);
}
//------------------------------------------------------------------------------------------------------//
//------------------------------------------------------------------------------------------------------//
//------------------------------------------------------------------------------------------------------//
if(1) {
    $sectionStyle = array(
        'orientation' => 'portrait',
        'marginTop' => Converter::cmToTwip(1.5),
        'marginLeft' => Converter::cmToTwip(1.5),
        'marginRight' => Converter::cmToTwip(1.5),
        'marginBottom' => Converter::cmToTwip(1.5)
    );
    $section = $doc->addSection($sectionStyle);
    //------------------------------------------------------------------------------------------------------//
    //------------------------------------------------------------------------------------------------------//
    //------------------------------------------------------------------------------------------------------//
    /*
    $styleTable = array(
        'borderSize' => 'none',
        'borderColor' =>'none',
        'layout'=> \PhpOffice\PhpWord\Style\Table::LAYOUT_FIXED
    );
    $table1 = $section->addTable($styleTable);
    $table1->addRow();
    $table1->addCell(Converter::cmToTwip(8));
    $table1_cell1 = $table1->addCell(Converter::cmToTwip(9));
    $table1_cell1->addText("Приложение 1",array('size'=>$font_size,'lang'=>'ru-RU'),array('align'=>'left','spaceAfter'=>0));
    $table1_cell1->addText("УТВЕРЖДЕНО",array('size'=>$font_size,'lang'=>'ru-RU'),array('align'=>'left','spaceAfter'=>0));
    $table1_cell1->addText("приказом Республиканской службы по контролю и надзору в сфере образования и науки",array('size'=>$font_size,'lang'=>'ru-RU'),array('align'=>'both','spaceAfter'=>0));
    $table1_cell1->addText("от ________________2021 г. № _______",array('size'=>$font_size,'lang'=>'ru-RU'),array('align'=>'left','spaceAfter'=>0));
    $table1_cell1->addText("",array('size'=>$font_size),array('spaceAfter'=>0));
    $section->addText("Форма",array('size'=>$font_size,'lang'=>'ru-RU'),array('align'=>'right','spaceAfter'=>0));
    $section->addText("",array('size'=>$font_size,'lang'=>'ru-RU'),array('align'=>'right','spaceAfter'=>0));
    */
    //------------------------------------------------------------------------------------------------------//
    //------------------------------------------------------------------------------------------------------//
    $section->addText("ИНДИВИДУАЛЬНЫЙ ЛИСТ",array('size'=>$font_size,'lang'=>'ru-RU','bold'=>true),array('align'=>'center','space' => $space_exact,'spaceAfter'=>0));
    $section->addText("ВЫПОЛНЕНИЯ ЗАДАНИЯ КВАЛИФИКАЦИОННОГО ЭКЗАМЕНА",array('size'=>$font_size,'lang'=>'ru-RU','bold'=>true),array('align'=>'center','space' => $space_exact,'spaceAfter'=>0));
    //------------------------------------------------------------------------------------------------------//
    //------------------------------------------------------------------------------------------------------//
    //------------------------------------------------------------------------------------------------------//
    //------------------------------------------------------------------------------------------------------//
    $sql_user_info = "SELECT id, 
    fio, 
    DATE_FORMAT(test_time_end, '%d.%m.%Y'),
    DATE_FORMAT(test_time_start, '%d.%m.%Y %H:%i'), 
    DATE_FORMAT(test_time_end, '%d.%m.%Y %H:%i'),
    DATE_FORMAT(sobesedovanie_time_start, '%d.%m.%Y %H:%i'), 
    DATE_FORMAT(sobesedovanie_time_end, '%d.%m.%Y %H:%i'), 
    test_result_confirm, 
    id_user 
    FROM teksperttest 
    WHERE udln is null and id=$id_eksperttest_doc";
    $res_user_info = mysqli_query($db, $sql_user_info);
    $line_user_info = mysqli_fetch_array($res_user_info, MYSQLI_NUM);
    $user_id = $line_user_info[0];
    $user_fio = $line_user_info[1];
    $user_test_time = $line_user_info[2];
    $user_test_time_start = $line_user_info[3];
    $user_test_time_end = $line_user_info[4];
    $user_sobesedovanie_time_start = $line_user_info[5];
    $user_sobesedovanie_time_end = $line_user_info[6];
    $user_test_result_confirm = $line_user_info[7];
    $user_id_user= $line_user_info[8];
    //------------------------------------------------------------------------------------------------------//
    $sql_login = "SELECT id,user FROM tusers WHERE udln is null and id=$user_id_user";
    $res_login = mysqli_query($db, $sql_login);
    $line_login = mysqli_fetch_array($res_login, MYSQLI_NUM);
    $usel_login = $line_login[1];
    //------------------------------------------------------------------------------------------------------//
    $section->addText("",array('size'=>$font_size,'lang'=>'ru-RU'),array('align'=>'right','space' => $space_exact,'spaceAfter'=>0));
    $section->addText("$user_fio",array('size'=>$font_size,'lang'=>'ru-RU','italic'=>true),array('align'=>'center','space' => $space_exact,'spaceBefore' => 0,'spaceAfter'=>0));
    $section->addText("_________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________",array('size'=>2),array('align'=>'left','space' => $space_exact_zero,'spaceAfter'=>0));
    $section->addText("(фамилия, имя, отчество претендента/эксперта, подлежащего аттестации/переаттестации)",array('size'=>12),array('align'=>'center','space' => $space_exact,'spaceAfter'=>0));
    $section->addText("",array('size'=>$font_size),array('spaceAfter'=>0));
    //------------------------------------------------------------------------------------------------------//
    $section->addText("$usel_login",array('size'=>$font_size,'lang'=>'ru-RU','italic'=>true),array('align'=>'center','space' => $space_exact,'spaceBefore' => 0,'spaceAfter'=>0));
    $section->addText("_________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________",array('size'=>2),array('align'=>'left','space' => $space_exact_zero,'spaceAfter'=>0));
    $section->addText("(логин для входа в автоматизированную информационную систему)",array('size'=>12),array('align'=>'center','space' => $space_exact,'spaceAfter'=>0));
    $section->addText("",array('size'=>$font_size),array('space' => $space_exact,'spaceAfter'=>0));
    //------------------------------------------------------------------------------------------------------//
    //------------------------------------------------------------------------------------------------------//
    //------------------------------------------------------------------------------------------------------//
    //$section->addText("",array('size'=>$font_size,'lang'=>'ru-RU'),array('align'=>'right','space' => $space_exact,'spaceAfter'=>0));
    //$section->addText("",array('size'=>$font_size,'lang'=>'ru-RU'),array('align'=>'right','space' => $space_exact,'spaceAfter'=>0));
    //------------------------------------------------------------------------------------------------------//
    $cellRowSpan = array('vMerge' => 'restart');
    $cellRowContinue = array('vMerge' => 'continue');
    $cellColSpan = array('gridSpan' => 2);

    $styleTable = array(
        'borderSize' => 1,
        'borderColor' =>'#000000',
        'layout'=> \PhpOffice\PhpWord\Style\Table::LAYOUT_FIXED,
        'cellMarginLeft'=>100,
        'cellMarginRight'=>100
    );
    $td1="1";
    $td2="10";
    $td3="7";
    $space=$tr_space;
    $size=$font_size;
    $table2_1 = $section->addTable($styleTable);

    $table2_1->addRow();
    $table2_1_cell1 = $table2_1->addCell(Converter::cmToTwip($td1));
    $table2_1_cell1->addText("1.",array('size'=>$size,'lang'=>'ru-RU'),array('align'=>'center','space' => $space_exact, 'spaceBefore' => $space, 'spaceAfter' => $space));
    $table2_1_cell2 = $table2_1->addCell(Converter::cmToTwip($td2));
    $table2_1_cell2->addText("Дата проведения квалификационного экзамена:",array('size'=>$size,'lang'=>'ru-RU'),array('align'=>'left','space' => $space_exact, 'spaceBefore' => $space, 'spaceAfter' => $space));
    $table2_1_cell3 = $table2_1->addCell(Converter::cmToTwip($td3),array('valign' => \PhpOffice\PhpWord\SimpleType\VerticalJc::CENTER));
    $table2_1_cell3->addText("$user_test_time",array('size'=>$size,'lang'=>'ru-RU'),array('align'=>'center','space' => $space_exact, 'spaceBefore' => $space, 'spaceAfter' => $space));

    $table2_1->addRow();
    $table2_1_cell1 = $table2_1->addCell(Converter::cmToTwip($td1));
    $table2_1_cell1->addText("2.",array('size'=>$size,'lang'=>'ru-RU'),array('align'=>'center','space' => $space_exact, 'spaceBefore' => $space, 'spaceAfter' => $space));
    $table2_1_cell2 = $table2_1->addCell(Converter::cmToTwip($td2));
    $table2_1_cell2->addText("Место проведения квалификационного экзамена:",array('size'=>$size,'lang'=>'ru-RU'),array('align'=>'left','space' => $space_exact, 'spaceBefore' => $space, 'spaceAfter' => $space));
    $table2_1_cell3 = $table2_1->addCell(Converter::cmToTwip($td3),array('valign' => \PhpOffice\PhpWord\SimpleType\VerticalJc::CENTER));
    $table2_1_cell3->addText("Ресобрнадзор",array('size'=>$size,'lang'=>'ru-RU'),array('align'=>'center','space' => $space_exact, 'spaceBefore' => $space, 'spaceAfter' => $space));

    $table2_1->addRow();
    $table2_1_cell1 = $table2_1->addCell(Converter::cmToTwip($td1));
    $table2_1_cell1->addText("3.",array('size'=>$size,'lang'=>'ru-RU'),array('align'=>'center','space' => $space_exact, 'spaceBefore' => $space, 'spaceAfter' => $space));
    $table2_1_cell2 = $table2_1->addCell(Converter::cmToTwip($td2));
    $table2_1_cell2->addText("Время начала тестирования:",array('size'=>$size,'lang'=>'ru-RU'),array('align'=>'left','space' => $space_exact, 'spaceBefore' => $space, 'spaceAfter' => $space));
    $table2_1_cell3 = $table2_1->addCell(Converter::cmToTwip($td3),array('valign' => \PhpOffice\PhpWord\SimpleType\VerticalJc::CENTER));
    $table2_1_cell3->addText("$user_test_time_start",array('size'=>$size,'lang'=>'ru-RU'),array('align'=>'center','space' => $space_exact, 'spaceBefore' => $space, 'spaceAfter' => $space));

    $table2_1->addRow();
    $table2_1_cell1 = $table2_1->addCell(Converter::cmToTwip($td1));
    $table2_1_cell1->addText("4.",array('size'=>$size,'lang'=>'ru-RU'),array('align'=>'center','space' => $space_exact, 'spaceBefore' => $space, 'spaceAfter' => $space));
    $table2_1_cell2 = $table2_1->addCell(Converter::cmToTwip($td2));
    $table2_1_cell2->addText("Время окончания тестирования:",array('size'=>$size,'lang'=>'ru-RU'),array('align'=>'left','space' => $space_exact, 'spaceBefore' => $space, 'spaceAfter' => $space));
    $table2_1_cell3 = $table2_1->addCell(Converter::cmToTwip($td3),array('valign' => \PhpOffice\PhpWord\SimpleType\VerticalJc::CENTER));
    $table2_1_cell3->addText("$user_test_time_end",array('size'=>$size,'lang'=>'ru-RU'),array('align'=>'center','space' => $space_exact, 'spaceBefore' => $space, 'spaceAfter' => $space));

    $table2_1->addRow();
    $table2_1_cell1 = $table2_1->addCell(Converter::cmToTwip($td1));
    $table2_1_cell1->addText("5.",array('size'=>$size,'lang'=>'ru-RU'),array('align'=>'center','space' => $space_exact, 'spaceBefore' => $space, 'spaceAfter' => $space));
    $table2_1_cell2 = $table2_1->addCell(Converter::cmToTwip($td2));
    $table2_1_cell2->addText("Время начала собеседования:",array('size'=>$size,'lang'=>'ru-RU'),array('align'=>'left','space' => $space_exact, 'spaceBefore' => $space, 'spaceAfter' => $space));
    $table2_1_cell3 = $table2_1->addCell(Converter::cmToTwip($td3),array('valign' => \PhpOffice\PhpWord\SimpleType\VerticalJc::CENTER));
    $table2_1_cell3->addText("$user_sobesedovanie_time_start",array('size'=>$size,'lang'=>'ru-RU'),array('align'=>'center','space' => $space_exact, 'spaceBefore' => $space, 'spaceAfter' => $space));

    $table2_1->addRow();
    $table2_1_cell1 = $table2_1->addCell(Converter::cmToTwip($td1));
    $table2_1_cell1->addText("6.",array('size'=>$size,'lang'=>'ru-RU'),array('align'=>'center','space' => $space_exact, 'spaceBefore' => $space, 'spaceAfter' => $space));
    $table2_1_cell2 = $table2_1->addCell(Converter::cmToTwip($td2));
    $table2_1_cell2->addText("Время окончания собеседования:",array('size'=>$size,'lang'=>'ru-RU'),array('align'=>'left','space' => $space_exact, 'spaceBefore' => $space, 'spaceAfter' => $space));
    $table2_1_cell3 = $table2_1->addCell(Converter::cmToTwip($td3),array('valign' => \PhpOffice\PhpWord\SimpleType\VerticalJc::CENTER));
    $table2_1_cell3->addText("$user_sobesedovanie_time_end",array('size'=>$size,'lang'=>'ru-RU'),array('align'=>'center','space' => $space_exact, 'spaceBefore' => $space, 'spaceAfter' => $space));
    //------------------------------------------------------------------------------------------------------//
    //------------------------------------------------------------------------------------------------------//
    //------------------------------------------------------------------------------------------------------//
    //------------------------------------------------------------------------------------------------------//
    //------------------------------------------------------------------------------------------------------//
    $section->addText("",array('size'=>$font_size,'lang'=>'ru-RU'),array('align'=>'left','space' => $space_exact, 'spaceBefore' => $space, 'spaceAfter' => $space));
    //------------------------------------------------------------------------------------------------------//
    //------------------------------------------------------------------------------------------------------//
    //------------------------------------------------------------------------------------------------------//
    //------------------------------------------------------------------------------------------------------//
    $cellRowSpan = array('vMerge' => 'restart');
    $cellRowContinue = array('vMerge' => 'continue');
    $cellColSpan2 = array('gridSpan' => 2);
    $cellColSpan4 = array('gridSpan' => 4);

    $styleTable = array(
        'borderSize' => 1,
        'borderColor' =>'#000000',
        'layout'=> \PhpOffice\PhpWord\Style\Table::LAYOUT_FIXED,
        'cellMarginLeft'=>100,
        'cellMarginRight'=>100,
        'align' => 'center'
    );
    $td1="3.5";
    $td2="3.5";
    $space=$tr_space;
    $size=$font_size;
    $table2_2 = $section->addTable($styleTable);
    //------------------------------------------------------------------------------------------------------//
    //$vopros_otvet[] = ["",""];
    //------------------------------------------------------------------------------------------------------//
    $table2_2->addRow();
    $table2_2_cell1 = $table2_2->addCell(null,$cellColSpan4);
    $table2_2_cell1->addText("Ответы на тест:",array('size'=>$size,'lang'=>'ru-RU','bold'=>true),array('align'=>'center','space' => $space_exact, 'spaceBefore' => $space, 'spaceAfter' => $space));
    //------------------------------------------------------------------------------------------------------//
    $sql_vopros = "SELECT
    teksperttest_vopros.id_vopros, 
    tvidi_vopros.name 
    FROM teksperttest_vopros 
    left join tvidi_vopros on tvidi_vopros.id=teksperttest_vopros.id_vopros 
    where teksperttest_vopros.udln is null 
    and tvidi_vopros.udln is null 
    and teksperttest_vopros.id_eksperttest=$user_id 
    group by teksperttest_vopros.id_vopros 
    order by tvidi_vopros.sort";
    $res_vopros = mysqli_query($db, $sql_vopros);
    $kolonka = 0;
    while ($line_vopros = mysqli_fetch_array($res_vopros, MYSQLI_NUM)) {

        $sql_vopros_variant = "SELECT 
        tvidi_vopros_variant.name 
        FROM teksperttest_vopros 
        left join tvidi_vopros_variant on tvidi_vopros_variant.id=teksperttest_vopros.id_vopros_variant 
        where teksperttest_vopros.udln is null 
        and tvidi_vopros_variant.udln is null 
        and teksperttest_vopros.id_eksperttest=$user_id 
        and teksperttest_vopros.id_vopros=$line_vopros[0]
        order by tvidi_vopros_variant.sort";
        $res_vopros_variant = mysqli_query($db, $sql_vopros_variant);
        $str_vopros_variant = "";
        while ($line_vopros_variant = mysqli_fetch_array($res_vopros_variant, MYSQLI_NUM)) {
            $str_vopros_variant .= "".my_substr0($line_vopros_variant[0],2)." ";
        }

        $vopros_otvet[] = ["".my_substr0($line_vopros[1],9)."","".$str_vopros_variant.""];

    }
    //------------------------------------------------------------------------------------------------------//
    if(count((array)$vopros_otvet)%2 == 0){
        $max_in_cell = count((array)$vopros_otvet)/2;
    }else{
        $max_in_cell = count((array)$vopros_otvet)/2+1;
    }
    //------------------------------------------------------------------------------------------------------//
    for($i=0;$i<$max_in_cell;$i++) {
        $table2_2->addRow();
        $table2_2->addCell(Converter::cmToTwip($td1))->addText(
            $vopros_otvet[$i][0],
            array('size' => $size, 'lang' => 'ru-RU', 'gridSpan' => 2),
            array('align' => 'left', 'space' => $space_exact, 'spaceBefore' => $space, 'spaceAfter' => $space)
        );
        $table2_2->addCell(Converter::cmToTwip($td2))->addText(
            $vopros_otvet[$i][1],
            array('size' => $size, 'lang' => 'ru-RU', 'gridSpan' => 2),
            array('align' => 'left', 'space' => $space_exact, 'spaceBefore' => $space, 'spaceAfter' => $space)
        );

        $table2_2->addCell(Converter::cmToTwip($td1))->addText(
            $vopros_otvet[($i+$max_in_cell)][0],
            array('size' => $size, 'lang' => 'ru-RU', 'gridSpan' => 2),
            array('align' => 'left', 'space' => $space_exact, 'spaceBefore' => $space, 'spaceAfter' => $space)
        );
        $table2_2->addCell(Converter::cmToTwip($td2))->addText(
            $vopros_otvet[($i+$max_in_cell)][1],
            array('size' => $size, 'lang' => 'ru-RU', 'gridSpan' => 2),
            array('align' => 'left', 'space' => $space_exact, 'spaceBefore' => $space, 'spaceAfter' => $space)
        );
    }
    //------------------------------------------------------------------------------------------------------//
    $table2_2->addRow();
    $table2_2_cell1 = $table2_2->addCell(null,$cellColSpan4);
    $tmp_str1 = $table2_2_cell1->addTextRun(
        array('align' => 'center', 'space' => $space_exact, 'spaceBefore' => $space, 'spaceAfter' => $space)
    );
    $tmp_str1->addText(
        "Результат прохождения тестирования: ",
        array('size' => $size, 'lang' => 'ru-RU'),
        array('align' => 'center', 'space' => $space_exact, 'spaceBefore' => $space, 'spaceAfter' => $size)
    );
    $tmp_str1->addText(
        "".chk_test_procent_prav_otvetov($id_eksperttest_doc)."",
        array('size' => $size, 'lang' => 'ru-RU', 'bold'=>true),
        array('align' => 'center', 'space' => $space_exact, 'spaceBefore' => $space, 'spaceAfter' => $space)
    );
    $tmp_str1->addText(
        " % ",
        array('size' => $size, 'lang' => 'ru-RU'),
        array('align' => 'center', 'space' => $space_exact, 'spaceBefore' => $space, 'spaceAfter' => $space)
    );
    //------------------------------------------------------------------------------------------------------//
    //------------------------------------------------------------------------------------------------------//
    //------------------------------------------------------------------------------------------------------//
    //------------------------------------------------------------------------------------------------------//
    $section->addText("",array('size'=>$font_size,'lang'=>'ru-RU'),array('align'=>'left','space' => $space_exact, 'spaceBefore' => $space, 'spaceAfter' => $space));
    //------------------------------------------------------------------------------------------------------//
    //------------------------------------------------------------------------------------------------------//
    //------------------------------------------------------------------------------------------------------//
    //------------------------------------------------------------------------------------------------------//
    $cellRowSpan = array('vMerge' => 'restart');
    $cellRowContinue = array('vMerge' => 'continue');
    $cellColSpan = array('gridSpan' => 2);

    $styleTable = array(
        'borderSize' => 1,
        'borderColor' =>'#000000',
        'layout'=> \PhpOffice\PhpWord\Style\Table::LAYOUT_FIXED,
        'cellMarginLeft'=>100,
        'cellMarginRight'=>100
    );
    $td1="9";
    $td2="9";
    $space=$tr_space;
    $size=$font_size;
    $table2_3 = $section->addTable($styleTable);
    //------------------------------------------------------------------------------------------------------//
    $table2_3->addRow();
    $table2_3_cell1 = $table2_3->addCell(null,$cellColSpan);
    $table2_3_cell1->addText("Ответы на собеседование:",array('size'=>$size,'lang'=>'ru-RU','bold'=>true),array('align'=>'center','space' => $space_exact, 'spaceBefore' => $space, 'spaceAfter' => $space));
    //------------------------------------------------------------------------------------------------------//
    $sql_sobesedovanie = "SELECT
    teksperttest_sobesedovanie.id, 
    tvidi_sobesedovanie.name, 
    teksperttest_sobesedovanie.sobesedovanie_otvet 
    FROM teksperttest_sobesedovanie 
    left join tvidi_sobesedovanie on tvidi_sobesedovanie.id=teksperttest_sobesedovanie.id_sobesedovanie 
    where teksperttest_sobesedovanie.udln is null 
    and tvidi_sobesedovanie.udln is null 
    and teksperttest_sobesedovanie.id_eksperttest=$user_id 
    order by tvidi_sobesedovanie.sort";
    $res_sobesedovanie = mysqli_query($db, $sql_sobesedovanie);
    while ($line_sobesedovanie = mysqli_fetch_array($res_sobesedovanie, MYSQLI_NUM)) {
        $table2_3->addRow();
        $table2_3_cell1 = $table2_3->addCell(Converter::cmToTwip($td1))->addText(
            "".check_string(delete_all_between('&lt;', '&gt;',$line_sobesedovanie[1]))."",
            array('size' => $size, 'lang' => 'ru-RU', 'gridSpan' => 2),
            array('align' => 'both', 'space' => $space_exact, 'spaceBefore' => $space, 'spaceAfter' => $space)
        );
        $table2_3_cell2 = $table2_3->addCell(Converter::cmToTwip($td2))->addText(
            "".$line_sobesedovanie[2]."",
            array('size' => $size, 'lang' => 'ru-RU'),
            array('align' => 'both', 'space' => $space_exact, 'spaceBefore' => $space, 'spaceAfter' => $space)
        );
    }
    //------------------------------------------------------------------------------------------------------//
    //------------------------------------------------------------------------------------------------------//
    //------------------------------------------------------------------------------------------------------//
    //------------------------------------------------------------------------------------------------------//
    //------------------------------------------------------------------------------------------------------//
    //------------------------------------------------------------------------------------------------------//
    $section->addText("",array('size'=>$font_size,'lang'=>'ru-RU'),array('align'=>'right','space' => $space_exact, 'spaceBefore' => $space, 'spaceAfter' => $space));
    //------------------------------------------------------------------------------------------------------//
    //------------------------------------------------------------------------------------------------------//
    //------------------------------------------------------------------------------------------------------//
    //------------------------------------------------------------------------------------------------------//
    //------------------------------------------------------------------------------------------------------//
    if($user_test_result_confirm==1){
        $podtverjdenie_login = $usel_login;
        $podtverjdenie_fio = $user_fio;
    }else{
        $podtverjdenie_login = "";
        $podtverjdenie_fio = "";
    }
    //------------------------------------------------------------------------------------------------------//
    $styleTable = array(
        'borderSize' => 'none',
        'borderColor' =>'none',
        'layout'=> \PhpOffice\PhpWord\Style\Table::LAYOUT_FIXED
    );
    $td1="6";
    $td2="6";
    $td3="6";
    $space=$tr_space;
    $size=$font_size;

    $table3 = $section->addTable($styleTable);
    $table3->addRow();
    $table3_cell1 = $table3->addCell(Converter::cmToTwip($td1));
    $table3_cell1->addText("Результат выполнения задания квалификационного экзамена подтверждаю",array('size'=>$size,'lang'=>'ru-RU'),array('align'=>'left','space' => $space_exact, 'spaceBefore' => $space, 'spaceAfter' => $space));
    $table3_cell2 = $table3->addCell(Converter::cmToTwip($td2),array('valign' => \PhpOffice\PhpWord\SimpleType\VerticalJc::BOTTOM));
    $table3_cell2->addText("$podtverjdenie_login",array('size'=>$size,'lang'=>'ru-RU'),array('align'=>'center','space' => $space_exact, 'spaceBefore' => $space, 'spaceAfter' => $space));
    $table3_cell2 = $table3->addCell(Converter::cmToTwip($td3),array('valign' => \PhpOffice\PhpWord\SimpleType\VerticalJc::BOTTOM));
    $table3_cell2->addText("$podtverjdenie_fio",array('size'=>$size,'lang'=>'ru-RU'),array('align'=>'center','space' => $space_exact, 'spaceBefore' => $space, 'spaceAfter' => $space));

    $table3->addRow();
    $table3_cell1 = $table3->addCell(Converter::cmToTwip($td1));
    $table3_cell1->addText("&#160;&#160;",array('size'=>2,'lang'=>'ru-RU'),array('align'=>'center','space' => $space_exact, 'spaceBefore' => $space, 'spaceAfter' => $space));
    $table3_cell2 = $table3->addCell(Converter::cmToTwip($td2));
    $table3_cell2->addText("_________________________________________________________________________________________________________________________________________",array('size'=>2,'lang'=>'ru-RU'),array('align'=>'center','space' => $space_exact_zero, 'spaceBefore' => $space, 'spaceAfter' => $space));
    $table3_cell2 = $table3->addCell(Converter::cmToTwip($td3));
    $table3_cell2->addText("____________________________________________________________________________________________________________________________________",array('size'=>2,'lang'=>'ru-RU'),array('align'=>'center','space' => $space_exact_zero, 'spaceBefore' => $space, 'spaceAfter' => $space));

    $table3->addRow();
    $table3_cell1 = $table3->addCell(Converter::cmToTwip($td1));
    $table3_cell1->addText("&#160;&#160;",array('size'=>2,'lang'=>'ru-RU'),array('align'=>'center','space' => $space_exact, 'spaceBefore' => $space, 'spaceAfter' => $space));
    $table3_cell2 = $table3->addCell(Converter::cmToTwip($td2));
    $table3_cell2->addText("(подпись (логин) претендента/эксперта, подлежащего аттестации/переаттестации)",array('size'=>10,'lang'=>'ru-RU'),array('align'=>'center','space' => $space_exact, 'spaceBefore' => $space, 'spaceAfter' => $space));
    $table3_cell2 = $table3->addCell(Converter::cmToTwip($td3));
    $table3_cell2->addText("(фамилия, имя, отчество (при наличии) претендента/эксперта, подлежащего аттестации/переаттестации)",array('size'=>10,'lang'=>'ru-RU'),array('align'=>'center','space' => $space_exact, 'spaceBefore' => $space, 'spaceAfter' => $space));
}
//------------------------------------------------------------------------------------------------------//
//------------------------------------------------------------------------------------------------------//
//------------------------------------------------------------------------------------------------------//
$file = str_replace(" ","_","Индивидуальный_лист_($user_fio)_($user_test_time).docx");
header("Content-Description: File Transfer");
header('Content-Disposition: attachment; filename="' . $file . '"');
header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
header('Content-Transfer-Encoding: binary');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Expires: 0');
$xmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($doc, 'Word2007');
$xmlWriter->save("php://output");
?>