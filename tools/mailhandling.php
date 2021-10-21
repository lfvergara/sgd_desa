<?php
require_once 'tools/Mandrill/Mandrill.php';


class EmailHelper extends View {
        public function envia_email($datos) { 
                $gui = file_get_contents("static/mail.html");
                $gui = str_replace("{theme_path}", THEME_PATH, $gui);
                $destinatario = $datos["correoelectronico"];
                $datos = $this->set_dict($datos);
                $gui = $this->render($datos, $gui);      
                $origen = "recuperos@cpcelr.org.ar";
                $asunto = "Recuperar Contraseña: CPCE";
                $array_final[] = array('email'=>$destinatario,'type'=>'to');
          
                $mandrill = new Mandrill('zxCTtQ5WNKT5OzMM2xUuWw');
                $message = array(
                'html' => $gui,
                'subject' => $asunto,
                    'from_email' => 'infocpcelr@cpcelr.org.ar',
                    'from_name' => 'Informes CPCE La Rioja',
                    'to' => $array_final,
                    'headers' => array('Reply-To' => 'infocpcelr@cpcelr.org.ar'),
                    'important' => false,
                    'track_opens' => true,
                    'track_clicks' => true,
                    'auto_text' => null,
                    'auto_html' => null,
                    'inline_css' => null,
                    'url_strip_qs' => null,
                    'preserve_recipients' => null,
                    'view_content_link' => null,
                    'tracking_domain' => true,
                    'signing_domain' => null,
                    'return_path_domain' => null,
                    'merge' => true,
                    'merge_language' => 'mailchimp',
                    'global_merge_vars' => array(
                        array(
                            'name' => 'merge1',
                            'content' => 'merge1 content'
                        )
                    )
                );
            
                $async = false;
                $ip_pool = 'Main Pool';
                //$send_at = '2014-02-20';
                $mandrill->messages->send($message, $async, $ip_pool, $send_at);
        }
  
        public function envia_email_actualizacion_matriculado($datos) { 
                $gui = file_get_contents("static/mail_actualizacion.html");
                $gui = str_replace("{theme_path}", THEME_PATH, $gui);
                $destinatario = "actualizaciondedatoscpcelr@gmail.com";
                //$destinatario = "hu.ce.ro@gmail.com";
                $datos = $this->set_dict($datos);
                $gui = $this->render($datos, $gui);      
                $origen = "actualizacionmatriculado@cpcelr.org.ar";
                $asunto = "Actualización de Datos de Matriculado";
                $array_final[] = array('email'=>$destinatario,'type'=>'to');
          
                $mandrill = new Mandrill('zxCTtQ5WNKT5OzMM2xUuWw');
                $message = array(
                'html' => $gui,
                'subject' => $asunto,
                    'from_email' => 'infocpcelr@cpcelr.org.ar',
                    'from_name' => 'Informes CPCE La Rioja',
                    'to' => $array_final,
                    'headers' => array('Reply-To' => 'infocpcelr@cpcelr.org.ar'),
                    'important' => false,
                    'track_opens' => true,
                    'track_clicks' => true,
                    'auto_text' => null,
                    'auto_html' => null,
                    'inline_css' => null,
                    'url_strip_qs' => null,
                    'preserve_recipients' => null,
                    'view_content_link' => null,
                    'tracking_domain' => true,
                    'signing_domain' => null,
                    'return_path_domain' => null,
                    'merge' => true,
                    'merge_language' => 'mailchimp',
                    'global_merge_vars' => array(
                        array(
                            'name' => 'merge1',
                            'content' => 'merge1 content'
                        )
                    )
                );
            
                $async = false;
                $ip_pool = 'Main Pool';
                //$send_at = '2014-02-20';
                $mandrill->messages->send($message, $async, $ip_pool, $send_at);
        }
  
        public function envia_email_estado_documento($datos_matriculado, $documento_detalle, $estado) { 
                $gui = file_get_contents("static/mail_actualizacion_estado_documento.html");
                $gui = str_replace("{documento_detalle}", $documento_detalle, $gui);
                $gui = str_replace("{estado}", $estado, $gui);
                $gui = str_replace("{theme_path}", THEME_PATH, $gui);
          
                $destinatario = $datos_matriculado[0]['correoelectronico'];
                //$matriculado = $datos_matriculado[0]['matriculado'];
                //$destinatario = "hu.ce.ro@gmail.com";
                $datos = $this->set_dict($datos);
                $gui = $this->render($datos, $gui);      
                $origen = "actualizacionmatriculado@cpcelr.org.ar";
                $asunto = "Actualización de Estado en Documento";
                $array_final[] = array('email'=>$destinatario,'type'=>'to');
          
                $mandrill = new Mandrill('zxCTtQ5WNKT5OzMM2xUuWw');
                $message = array(
                'html' => $gui,
                'subject' => $asunto,
                    'from_email' => 'infocpcelr@cpcelr.org.ar',
                    'from_name' => 'Informes CPCE La Rioja',
                    'to' => $array_final,
                    'headers' => array('Reply-To' => 'infocpcelr@cpcelr.org.ar'),
                    'important' => false,
                    'track_opens' => true,
                    'track_clicks' => true,
                    'auto_text' => null,
                    'auto_html' => null,
                    'inline_css' => null,
                    'url_strip_qs' => null,
                    'preserve_recipients' => null,
                    'view_content_link' => null,
                    'tracking_domain' => true,
                    'signing_domain' => null,
                    'return_path_domain' => null,
                    'merge' => true,
                    'merge_language' => 'mailchimp',
                    'global_merge_vars' => array(
                        array(
                            'name' => 'merge1',
                            'content' => 'merge1 content'
                        )
                    )
                );
            
                $async = false;
                $ip_pool = 'Main Pool';
                //$send_at = '2014-02-20';
                $mandrill->messages->send($message, $async, $ip_pool, $send_at);
        }
        
        public function envia_email_turnoonline($datos) { 
            $gui = file_get_contents("static/mail_turnoonline.html");
            $destinatario = $datos['email'];
            $datos = $this->set_dict($datos);
            $gui = $this->render($datos, $gui);      
            $origen = "actualizacionmatriculado@cpcelr.org.ar";
            $asunto = "CPCE - Turno OnLine";
            $array_final[] = array('email'=>$destinatario,'type'=>'to');
            //$array_final[] = array('email'=>'devteam.edelar@gmail.com','type'=>'to');

            $mandrill = new Mandrill('zxCTtQ5WNKT5OzMM2xUuWw');
            $message = array(
            'html' => $gui,
            'subject' => $asunto,
                'from_email' => 'infocpcelr@cpcelr.org.ar',
                'from_name' => 'Informes CPCE La Rioja',
                'to' => $array_final,
                'headers' => array('Reply-To' => 'infocpcelr@cpcelr.org.ar'),
                'important' => false,
                'track_opens' => true,
                'track_clicks' => true,
                'auto_text' => null,
                'auto_html' => null,
                'inline_css' => null,
                'url_strip_qs' => null,
                'preserve_recipients' => null,
                'view_content_link' => null,
                'tracking_domain' => true,
                'signing_domain' => null,
                'return_path_domain' => null,
                'merge' => true,
                'merge_language' => 'mailchimp',
                'global_merge_vars' => array(
                    array(
                        'name' => 'merge1',
                        'content' => 'merge1 content'
                    )
                )
            );

            $async = false;
            $ip_pool = 'Main Pool';
            //$send_at = '2014-02-20';
            $mandrill->messages->send($message, $async, $ip_pool, $send_at);
        }
}
?>