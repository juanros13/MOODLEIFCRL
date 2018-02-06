<?php
date_default_timezone_set('America/Mexico_City');

require_once 'Constants.php';
require_once 'html2pdf/html2pdf.class.php';

/**
 * Certification
 *
 * Clase encargada de generar las constancias emitidas por el aplicativo PROCADIST
 * Este objeto es invocado desde el PHP_CLI a modo de shell
 */
class Certification
{
    /**
     * Método encargado de guardar en la base de datos el certificado generado por el aplicativo
     */
     public function saveCertificate($id, $fullName, $curp, $idCourse, $courseName, $startDate, $grade)
     {
         $dbconn=pg_connect("host=".HOST." port=".PORT." dbname=".DB_NAME." user=".DB_USER." password=".DB_PASS."");
         // $dbconn =pg_connect("host=172.16.50.52 port=5432 dbname=moodle user=moodle password=m00d!3");
         $monthArray = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];

        //Verifica que el paso de parametros sea válido
        if (isset($id)         &&
            isset($fullName)   &&
            isset($curp)       &&
            isset($idCourse)   &&
            isset($courseName) &&
            isset($startDate)  &&
            isset($grade)
        ) {
            // calcula la decha de vigencia del certificado
            $start = new DateTime($startDate); // para usar en _template
            $end   = new DateTime($startDate);
            $end->add(new DateInterval('P10D'));

            $expired = $end;
            $expired->add(new DateInterval('P2Y'));
            $differenceYear = "";

            $folio = substr(md5($id . $courseName . $fullName . CERT_APP), 0, 6); // calcula el folio del certificado
            $filename = $folio . '.pdf';
            $md5Folio = md5($folio);
            $url = URL_PORTAL . 'CertificateAdminReport/downloadCertificate/' . $md5Folio;
            $urlValidate = URL_PORTAL . 'CerticateValidate/index/' . $folio;
            $filesize = 1024;
            $text = "";


            if ($start->format('m') === $end->format('m')) {
                $text = 'Del ' . $start->format('d') . ' al ' .
                         $end->format('d') . ' de ' .
                         $monthArray[intval($start->format('m')) - 1] .
                         ' de ' . $start->format('Y');
            } else {
                if ($start->format('m') === '12' &&  $end->format('m') === '1') {
                    $differenceYear = ' de ' . $start->format('Y');
                }

                $text = 'Del ' . $start->format('d') . ' de ' .
                         $monthArray[intval($start->format('m')) - 1] .
                         $differenceYear . ' al ' . $end->format('d') . ' de ' .
                         $monthArray[intval($end->format('m')) - 1] .
                         ' de ' . $end->format('Y');
            }
            
            $textExpired=''.$expired->format('d').' DE '.strtoupper($monthArray[intval($expired->format('m'))-1]).' DEL '.$expired->format('Y');
 
            // obtiene el template del certificado
            ob_start();
            include CERT_APP.'_template.php';
            $content = ob_get_clean();
            
	    try
            {
                require_once 'html2pdf/html2pdf.class.php';
                $html2pdf = new HTML2PDF('P', 'A4', 'en', true, 'UTF-8');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $pdfContent = $html2pdf->Output('', true);

                $escaped = bin2hex($pdfContent);

                $result = pg_query("SELECT folio FROM mdl_alt_tbl_certificate WHERE folio = '{$folio}'");
                $cerExist = pg_fetch_row($result);
                
                if (!$cerExist) {
                    // inserta el certificado en la base de datos
                    $result = pg_query("INSERT INTO mdl_alt_tbl_certificate (
                                            iduser,
                                            folio,
                                            filename,
                                            filesize,
                                            data,
                                            expiredat,
                                            secret,
                                            coursename,
                                            startperiod,
                                            endperiod,
                                            grade,
                                            idcourse )
                                        VALUES (
                                            '{$id}',
                                            '{$folio}',
                                            '{$filename}',
                                            '{$filesize}',
                                            decode (
                                                '{$escaped}',
                                                'hex' ),
                                            '{$expired->format('Y-m-d G:i:s')}',
                                            '{$md5Folio}',
                                            '{$courseName}',
                                            '{$start->format('Y-m-d G:i:s')}',
                                            '{$end->format('Y-m-d G:i:s')}',
                                            '{$grade}',
                                            '{$idCourse}' ) ");

                    if ($result === false) {
                        print pg_last_error($dbconn);
                        return false;
                    } else {
                        return $url;
                    }
                } else {
                    return false;
                }
            } catch (HTML2PDF_exception $e) {
                echo $e;
                return false;
            }

        } else {
            return false;
        }
    }

}
