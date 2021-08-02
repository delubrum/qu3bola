<?php
date_default_timezone_set ('America/Los_Angeles');
setlocale(LC_ALL, "en_US.UTF-8");
ob_start();
require('assets/fpdf/fpdf.php');
class PDF extends FPDF
{
var $widths;
var $aligns;
    var $B=0;
    var $I=0;
    var $U=0;
    var $HREF='';
    var $ALIGN='';




function WriteHTML($html)
    {
        //HTML parser
        $html=str_replace("\n",' ',$html);
        $a=preg_split('/<(.*)>/U',$html,-1,PREG_SPLIT_DELIM_CAPTURE);
        foreach($a as $i=>$e)
        {
            if($i%2==0)
            {
                //Text
                if($this->HREF)
                    $this->PutLink($this->HREF,$e);
                elseif($this->ALIGN=='center')
                    $this->Cell(0,5,$e,0,1,'C');
                else
                    $this->Write(5,$e);
            }
            else
            {
                //Tag
                if($e[0]=='/')
                    $this->CloseTag(strtoupper(substr($e,1)));
                else
                {
                    //Extract properties
                    $a2=explode(' ',$e);
                    $tag=strtoupper(array_shift($a2));
                    $prop=array();
                    foreach($a2 as $v)
                    {
                        if(preg_match('/([^=]*)=["\']?([^"\']*)/',$v,$a3))
                            $prop[strtoupper($a3[1])]=$a3[2];
                    }
                    $this->OpenTag($tag,$prop);
                }
            }
        }
    }

    function OpenTag($tag,$prop)
    {
        //Opening tag
        if($tag=='B' || $tag=='I' || $tag=='U')
            $this->SetStyle($tag,true);
        if($tag=='A')
            $this->HREF=$prop['HREF'];
        if($tag=='BR')
            $this->Ln(5);
        if($tag=='P')
            $this->ALIGN=$prop['ALIGN'];
        if($tag=='HR')
        {
            if( !empty($prop['WIDTH']) )
                $Width = $prop['WIDTH'];
            else
                $Width = $this->w - $this->lMargin-$this->rMargin;
            $this->Ln(2);
            $x = $this->GetX();
            $y = $this->GetY();
            $this->SetLineWidth(0.4);
            $this->Line($x,$y,$x+$Width,$y);
            $this->SetLineWidth(0.2);
            $this->Ln(2);
        }
    }

    function CloseTag($tag)
    {
        //Closing tag
        if($tag=='B' || $tag=='I' || $tag=='U')
            $this->SetStyle($tag,false);
        if($tag=='A')
            $this->HREF='';
        if($tag=='P')
            $this->ALIGN='';
    }

    function SetStyle($tag,$enable)
    {
        //Modify style and select corresponding font
        $this->$tag+=($enable ? 1 : -1);
        $style='';
        foreach(array('B','I','U') as $s)
            if($this->$s>0)
                $style.=$s;
        $this->SetFont('',$style);
    }

    function PutLink($URL,$txt)
    {
        //Put a hyperlink
        $this->SetTextColor(0,0,255);
        $this->SetStyle('U',true);
        $this->Write(5,$txt,$URL);
        $this->SetStyle('U',false);
        $this->SetTextColor(0);
    }



function Header()
{   
    $this->Image('assets/img/membrete.png',0,0,216,279);
}

function Footer()
{
    // Posición: a 1,5 cm del final
    $this->SetY(-15);
    // Arial italic 8
$this->AddFont('gothic','B','gothicb.php');
    $this->SetFont('gothic','',11); 
    // Número de página
    $this->Cell(192,10,utf8_decode($this->PageNo().':{nb}'),0,0,'R');
}


function SetWidths($w)
{
    //Set the array of column widths
    $this->widths=$w;
}

function SetAligns($a)
{
    //Set the array of column alignments
    $this->aligns=$a;
}

function Row($data)
{
    //Calculate the height of the row
    $nb=0;
    for($i=0;$i<count($data);$i++)
        $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
    $h=5*$nb;
    //Issue a page break first if needed
    $this->CheckPageBreak($h);
    //Draw the cells of the row
    for($i=0;$i<count($data);$i++)
    {
        $w=$this->widths[$i];
        $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
        //Save the current position
        $x=$this->GetX();
        $y=$this->GetY();
        //Draw the border
        $this->Rect($x,$y,$w,$h);
        //Print the text
        $this->MultiCell($w,5,$data[$i],0,$a);
        //Put the position to the right of the cell
        $this->SetXY($x+$w,$y);
    }
    //Go to the next line
    $this->Ln($h);
}

function CheckPageBreak($h)
{
    //If the height h would cause an overflow, add a new page immediately
    if($this->GetY()+$h>$this->PageBreakTrigger)
        $this->AddPage($this->CurOrientation);
}

function NbLines($w,$txt)
{
    //Computes the number of lines a MultiCell of width w will take
    $cw=&$this->CurrentFont['cw'];
    if($w==0)
        $w=$this->w-$this->rMargin-$this->x;
    $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
    $s=str_replace("\r",'',$txt);
    $nb=strlen($s);
    if($nb>0 and $s[$nb-1]=="\n")
        $nb--;
    $sep=-1;
    $i=0;
    $j=0;
    $l=0;
    $nl=1;
    while($i<$nb)
    {
        $c=$s[$i];
        if($c=="\n")
        {
            $i++;
            $sep=-1;
            $j=$i;
            $l=0;
            $nl++;
            continue;
        }
        if($c==' ')
            $sep=$i;
        $l+=$cw[$c];
        if($l>$wmax)
        {
            if($sep==-1)
            {
                if($i==$j)
                    $i++;
            }
            else
                $i=$sep+1;
            $sep=-1;
            $j=$i;
            $l=0;
            $nl++;
        }
        else
            $i++;
    }
    return $nl;
}
}

function GenerateWord()
{
    //Get a random word
    $nb=rand(3,10);
    $w='';
    for($i=1;$i<=$nb;$i++)
        $w.=chr(rand(ord('a'),ord('z')));
    return $w;
}

function GenerateSentence()
{
    //Get a random sentence
    $nb=rand(1,10);
    $s='';
    for($i=1;$i<=$nb;$i++)
        $s.=GenerateWord().' ';
    return substr($s,0,-1);
}

$pdf = new PDF('P','mm',array(216,279));
$fill="";
$pdf->SetMargins(20, 50 , 20); 

$pdf->SetAutoPageBreak(true,20);  
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->AddFont('gothic','','gothic.php');
$pdf->AddFont('gothic','B','gothicb.php');
$pdf->SetFont('gothic','',10);
$fecha=ucfirst(strftime("%B %d, %Y")) . ".";

$pdf->Ln(-43);

$pdf->SetTextColor(0,0,0);
$pdf->SetFont('gothic','',10);
$pdf->Ln(12);
$codi=  str_pad($cod->ID, 4, "0", STR_PAD_LEFT);
$proyecto=mb_convert_case($cod->proyecto, MB_CASE_TITLE, "UTF-8") . " - Quote " . $codi ;
$pdf->SetFont('gothic','B',14);

$pdf->MultiCell(130,5,utf8_decode($proyecto),'','L',0,'');
$pdf->Ln(0);
$ciudadpro=explode(',',trim($cod->ciudad));
$ciudadpro=$ciudadpro[0]. "," . $ciudadpro[1];
$cproyecto=mb_convert_case($ciudadpro, MB_CASE_TITLE, "UTF-8");
$pdf->Cell(0,5,utf8_decode($cproyecto),0,1);
$pdf->Ln(10);
$pdf->SetFont('gothic','',10);
$pdf->Cell(0,5,utf8_decode($fecha),'',0,'');
$pdf->Ln(10);
$contacto =mb_convert_case($this->model->Obtener_Clienteb($cod->cliente)->nombre, MB_CASE_TITLE, "UTF-8");
$pdf->Cell(0,5,utf8_decode('Mr(s). ' . $contacto),0,1);
$pdf->SetFont('gothic','b',10);
$empresa = mb_convert_case($this->model->Obtener_Clienteb($cod->cliente)->empresa, MB_CASE_TITLE, "UTF-8");
$pdf->Cell(0,5,utf8_decode($empresa),0,1);


$pdf->SetTextColor(0,0,0);
$pdf->SetFont('gothic','',10);
$ciudad=$contacto =mb_convert_case($this->model->Obtener_Clienteb($cod->cliente)->ciudad, MB_CASE_TITLE, "UTF-8");



$pdf->Cell(0,5,utf8_decode($ciudad),0,1);
$pdf->Ln(2);
$pdf->Cell(0,5,utf8_decode('We are pleased to provide you with the following proposal and corresponding terms and conditions.'),0,1);
$pdf->Ln(2);


$pdf->Image($img,null,null,175.9);


$cont=1;
$contaropc=0;

if (!empty($this->model->Listar_Opc($_REQUEST['id']))) { foreach($this->model->Listar_Opc($_REQUEST['id']) as $k) {
$contaropc += 1;
}}


if (!empty($this->model->Listar_Opc($_REQUEST['id']))) { foreach($this->model->Listar_Opc($_REQUEST['id']) as $k) :


if ($contaropc >1) {

$pdf->Ln();
$pdf->SetFont('gothic','',14);
$pdf->SetTextColor(100,100,100);
$textopc= "Option - " . $cont; 
$pdf->Cell(0,5,utf8_decode($textopc),0,1,'L');
}


$pdf->Ln();

if (!empty($this->model->Listar_Cot_Opc($cod->ID,$k->opc))){
    
$pdf->SetFont('gothic','',9); 
$pdf->Cell(10,5,"Item",'1',0,'L',$fill);
$pdf->Cell(85,5,utf8_decode("Description"),'1',0,'L',$fill);
$pdf->Cell(10,5,"Units",'1',0,'L',$fill);
$pdf->Cell(15,5,"Quantity",'1',0,'L',$fill);
$pdf->Cell(28,5,"Cost per Unit",'1',0,'L',$fill);
$pdf->Cell(28,5,"Total",'1',0,'L',$fill);
$pdf->Ln();
$pdf->SetWidths(array(10,85,10,15,28,28));
$pdf->SetAligns(array('L','L','C','C','R','R'));    
    
 $valorantesiva= 0;
$i=0;    


$CCom=explode('||',$cod->CC);
foreach($this->model->Listar_Cot_Opc($cod->ID,$k->opc) as $r) {




$i=$i+1;

(isset($CCom[3]) and $CCom[3] <> 'USD') ? $valorudd=$r->valor :$valorudd=$r->valor/$CCom[0];
$valorudd=$valorudd/(1-($r->margen/100));
$valorudd=$valorudd+($valorudd*($CCom[1]/100))+($valorudd*($CCom[2]/100));
$valorudd=ceil($valorudd);
$valorud= number_format($valorudd/$r->cantidad, 2, ',', '.');
$valortotal= number_format($valorudd, 0, '', '.');

$obsitem= mb_convert_case($r->referencia, MB_CASE_UPPER, "UTF-8") . "\n\n" . ucfirst($r->descripcion);

$pdf->Row(array($i,utf8_decode($obsitem), $r->und,$r->cantidad, "$ $valorud", "$ $valortotal"));

$valorantesiva += $valorudd;

 }
 }
 
 $valorantesiva = number_format($valorantesiva, 0, '', '.');;

$pdf->Cell(120,5,'',0,0,'R');
$pdf->Cell(28,5,"TOTAL",'1',0,'R',$fill);
$pdf->Cell(28,5,"$ $valorantesiva",'1',0,'R',$fill);

$cont++;
endforeach;}

$pdf->AddPage();


$texto = str_replace("strong", "b", $cod->texto);
$texto = str_replace("<p>", "<br>", $texto);
$texto = stripslashes($texto);

$pdf->SetFont('gothic');
$pdf->SetFontSize(10);
$pdf->WriteHTML(utf8_decode(html_entity_decode($texto)));

$proyecton=mb_convert_case($cod->proyecto, MB_CASE_TITLE, "UTF-8");
$pdf->Output("PDF/ES METALS PROPOSAL - $proyecton.pdf","F");

ob_end_flush(); 


?>