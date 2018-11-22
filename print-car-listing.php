<?php


if(isset($_POST["create_pdf"])){ 

     include(get_stylesheet_directory().'/tcpdf/tcpdf.php');  

             // Extend the TCPDF class to create custom Header and Footer
        class ASIANIMPORTS extends TCPDF {

            //Page header
            public function Header() {
               $this->Rect(0, 0, 2000, 21,'F',array(),'#555555');
                // Logo
                $image_file = K_PATH_IMAGES.'logo.png';
                $this->Image($image_file, 10, 6, 30, '', 'png', '', 'T', false, 400, '', false, false, 0, false, false, false);
            }

            // Page footer
            public function Footer() {
                // Position at 15 mm from bottom
                $this->SetY(-30);
                // Set font
                $this->SetFont('helvetica', 'I', 8);
                $this->SetMargins('10', '0', '10'); 

                $footertext = '
                 <p><span style="font-weight:bold;">Asian Imports Limited</span><br>House: 21, Road: 103, Gulshan: 02 ,1212 Dhaka, Bangladesh<br>+880188-6000 300</p>
                 <p><strong>Please Note:</strong> Asian Imports Ltd will use reasonable endeavours to ensure the accuracy of the above information and the picture created from it, some inaccuracies may occur. Please check with your
dealer about any terms which may affect your decision to buy this vehicle. This vehicle may have been sold in the last 24 hours. Please contact us to confirm the vehicle is still available.</p>


               ';
                // output the HTML content
                // writeHTML($html, $ln=true, $fill=false, $reseth=false, $cell=false, $align='')
                $this->writeHTML($footertext, true, false, true, false, 'center');

            }
        }
              $pdf = new ASIANIMPORTS('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  
              $pdf->SetCreator(PDF_CREATOR);  
              $pdf->SetTitle("Export HTML Table data to PDF using TCPDF in PHP");  
              // set default header data
              $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 048', PDF_HEADER_STRING);
              $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));  
              $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));  
              $pdf->SetDefaultMonospacedFont('helvetica');   
              $pdf->SetMargins(0, '20', 0);  
              $pdf->setPrintHeader(true);  
              $pdf->setPrintFooter(true);  
              $pdf->SetAutoPageBreak(TRUE, 10);  
              $pdf->SetFont('helvetica', '', 12);  
              $pdf->AddPage(); 
          
              $featured_img = '<img style="border-top:2px solid #fff;border-right:2px solid #fff" width="auto" height="auto" src="'.$featured_img_src[0].'">';

                $header_banner = '';
                $header_banner .= '<style>
                            .gallery-thumb{
                            }
                            .single-car-price {
                              color:#2C2C2C;
                              font-size:20px;
                            }
                            .single-car-prices {
                                background-color: #182b45;
                            }
                             .h4 {
                                  
                                  color:#fff;
                                  font-weight:bold;
                                }
                            .regular-price-with-sale {
                              text-transform:uppercase;
                              font-weight:bold;
                              color:#fff;
                            }
                          .sale-price-description-single {
                            background-color:#232628;
                            color:#fff;
                            text-align:center;
                          }
                    </style>';
                $header_banner .='
                <div style="background-color:#d3d3d3">
                  <table cellspacing="5" cellpadding="5">
                      <tr>
                        <td>'.$featured_img.'
                            <table cellspacing="3" cellpadding="1" border="0">
                              <tr>';
               $gallery = get_post_meta(get_the_id() , 'gallery', true);
               if (!empty($gallery)){  
                  foreach($gallery as $gallery_image)
                      {
                      $src = wp_get_attachment_image_src($gallery_image, 'stm-img-796-466');
                      $full_src = wp_get_attachment_image_src($gallery_image, 'full');
                      if (!empty($src[0]) && $gallery_image != get_post_thumbnail_id(get_the_ID())) {
                           
                            $header_banner.='<td><img src="'.$full_src[0].'"></td>';                        
                        }
                      }
                  }
                $header_banner.= '</tr>
                            </table>
                          </td>
                        <td><p style="text-align:left;color:#2C2C2C;line-height:16px"><span style="font-size:20px;font-weight:bold">Asian Imports Limited</span><br>Gulshan: 02,Dhaka<br><span style="font-weight:bold">+880188-6000 300</span></p>
                        <h2 style="text-transform:uppercase;">'.$car_datas['make'][0].'</h2><h1 style="font-weight:normal;text-align:left;color:#2C2C2C;">'.$car_title.'</h1>';
                          
                          if(isset($car_datas['sale_price']) && !empty($car_datas['sale_price'])) {
                                      $savings = $car_datas['price'][0]-$car_datas['sale_price'][0];
                                      $header_banner.='<div class="single-car-prices">
                                              <table>
                                                  <tr>
                                                    <td>
                                                      <div class="regular-price-with-sale">REGULAR PRICE<br><strong>BDT '.$car_datas['price'][0].'</strong></div>
                                                    </td>
                                                    <td>
                                                      <div class="h4" style="margin-top:0">SALE PRICE<br>BDT '.$car_datas['sale_price'][0].'</div>
                                                    </td>
                                                  </tr>
                                                  <tr>
                                                    <div class="sale-price-description-single">
                                                    SAVINGS BDT '.$savings.'
                                                    </div>
                                                  </tr>
                                                </table>
                                            </div>';
                                    } 
                          else {
                            $header_banner.='<div style="text-align:left" class="single-car-price"><strong>BDT '.$car_datas['price'][0].'</strong></div>';
                          }
                $header_banner.='</td>
                      </tr>
                   </table>
                 </div>
                ';
              $content  = '';
              $content .= '<style>
                        table {
                          padding-right:20px;
                        }

                      ul.asian_car_details {
                          list-style-type:none;
                        }
                        ul.asian_car_details li {
                        width:50%;
                        display:block;
                        float:left;
                        }
                        ul.asian_car_details li span {
                            font-weight:bold;
                            color:#4D4E4F;
                        }
                    </style>';

            
            

            $content .= '<table>
                            <tr>
                                <td>
                                  '.$car_features.'
                                </td>
                                 <td>
                                    <table cellpadding="5">
                                        <tr>
                                            <td><strong>Make</strong></td>
                                            <td align="right">'.$car_datas['make'][0].'</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Model</strong></td>
                                            <td  align="right">'.$car_datas['serie'][0].'</td>
                                        </tr>
                                         <tr>
                                            <td><strong>Exterior Color</strong></td>
                                            <td  align="right">'.$car_datas['exterior-color'][0].'</td>
                                        </tr>
                                         <tr>
                                            <td><strong>Interior Color</strong></td>
                                            <td  align="right">'.$car_datas['interior-color'][0].'</td>
                                        </tr>
                                         <tr>
                                            <td><strong>Year</strong></td>
                                            <td  align="right">'.$car_datas['ca-year'][0].'</td>
                                        </tr>
                                         <tr>
                                            <td><strong>Mileage</strong></td>
                                            <td  align="right">'.$car_datas['mileage'][0].'(km)</td>
                                        </tr>
                                          <tr>
                                            <td><strong>Fuel Type</strong></td>
                                            <td  align="right">'.$car_datas['fuel'][0].'</td>
                                        </tr>
                                           <tr>
                                            <td><strong>Transmission</strong></td>
                                            <td  align="right">'.$car_datas['transmission'][0].'</td>
                                        </tr>
                                          <tr>
                                            <td><strong>Engine</strong></td>
                                            <td  align="right">'.$car_datas['engine'][0].'(cc)</td>
                                        </tr>
                                         <tr>
                                            <td><strong>Number of Seats</strong></td>
                                            <td  align="right">'.$car_datas['seat'][0].'</td>
                                        </tr>
                                        
                                    </table>
                                </td>
                            </tr>
                
                        </table>';
              $pdf->writeHTML($header_banner);
              $pdf->writeHTML($content); 
                 // set style for barcode
                $style = array(
                  'border' => 2,
                  'vpadding' => 'auto',
                  'hpadding' => 'auto',
                  'fgcolor' => array(0,0,0),
                  'bgcolor' => false, //array(255,255,255)
                  'module_width' => 1, // width of a single module in points
                  'module_height' => 1 // height of a single module in points
                );
                $car_listing_url = get_permalink( $post->ID );
              // QRCODE,Q : QR-CODE Better error correction
              $pdf->write2DBarcode($car_listing_url, 'QRCODE,Q', 140, 230, 50, 50, $style, 'N');
              ob_end_clean();
              $pdf->Output('CarSpecs.pdf', 'I');  
      
 }   
