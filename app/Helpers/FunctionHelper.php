<?php

# created by longuyvinh 
# document: https://asked.io/creating-helper-classes-in-laravel-5-1

namespace App\Helpers;

use TCPDF;
use TCPDF_FONTS;
use Illuminate\Support\Facades\Session;
use App\Models\Facility;

class FunctionHelper
{

    public static function somethingOrOther()
    {

        return (mt_rand(1, 2) == 1) ? 'something' : 'other';
    }

    public static function removeSign($a)
    {
        $a = preg_replace('/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/', "a", $a);
        $a = preg_replace('/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/', "e", $a);
        $a = preg_replace('/ì|í|ị|ỉ|ĩ/', "i", $a);
        $a = preg_replace('/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/', "o", $a);
        $a = preg_replace('/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/', "u", $a);
        $a = preg_replace('/ỳ|ý|ỵ|ỷ|ỹ/', "y", $a);
        $a = preg_replace('/đ/', "d", $a);
        $a = preg_replace('/À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ/', "A", $a);
        $a = preg_replace('/È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ/', "E", $a);
        $a = preg_replace('/Ì|Í|Ị|Ỉ|Ĩ/', "I", $a);
        $a = preg_replace('/Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ/', "O", $a);
        $a = preg_replace('/Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ/', "U", $a);
        $a = preg_replace('/Ỳ|Ý|Ỵ|Ỷ|Ỹ/', "Y", $a);
        $a = preg_replace('/Đ/', "D", $a);
        $a = preg_replace('/[$\\@\\\#%\^\&\*\(\)\[\]\+\_\!\"\'\>\<\?\,\.\;\:\/\	\{\}\`\~\=\|]/', "", $a);
        $a = trim($a);
        return $a;
    }

    public static function slugify($a)
    {
        $a = strtolower($a);
        $a = preg_replace('/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/', "a", $a);
        $a = preg_replace('/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/', "e", $a);
        $a = preg_replace('/ì|í|ị|ỉ|ĩ/', "i", $a);
        $a = preg_replace('/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/', "o", $a);
        $a = preg_replace('/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/', "u", $a);
        $a = preg_replace('/ỳ|ý|ỵ|ỷ|ỹ/', "y", $a);
        $a = preg_replace('/đ|Đ/', "d", $a);
        $a = preg_replace('/[$\\@\\\#%\^\&\*\(\)\[\]\+\_\!\"\'\>\<\?\,\.\;\:\/{\}\`\~\=\|]/', "", $a);
        $a = trim($a);
        $a = preg_replace('/\s+/', "-", $a);
        return $a;
    }

    public static function custom_number_format($n, $lang = 'K,M,B')
    {
        $arr_lang = explode(',', $lang);
        if ($n < 1000) {
            $n_format = number_format($n);
        } else if ($n < 1000000) {
            $n_format = number_format($n / 1000) . $arr_lang[0];
        } else if ($n < 1000000000) {
            $n_format = number_format($n / 1000000, 1) . $arr_lang[1];
        } else {
            $n_format = number_format($n / 1000000000, 2) . $arr_lang[2];
        }
        return $n_format;
    }

    public static function searchInArrayObject($array, $key, $value)
    {
        foreach ($array as $object) {
            if ($object[$key] == $value) {
                return $object;
            }
        }
        return array();
    }

    /**
     * @Desc generate HTML string from input
     * @return void
     * @copyright by Issac Nguyen
     * @author Hung <hung@magiclabs.vn>
     */
    public static function generatePDFContent2($property, $propertyLang, $fileName, $lang)
    {
        if ($lang == 'vi') {
            $strAllDetail = "Chi tiết bất động sản";
            $strAskingPrice = "Giá";
            $strBedroom = "Số phòng ngủ";
            $strBathroom = "Số phòng tắm";
            $strBuiltUp = "Diện tích xây dựng";
            $strFurnishing = "Nội thất";
            $strFloor = "Số tầng";
            $strClassification = "Phân loại";
            $strOccupancy = "Loại sở hữu";
            $strYearBuilt = "Năm xây dựng";
            $strPossibleTerm = "Thời hạn hợp đồng";
            $strPostedDate = "Ngày đăng";
            $strDescription = "Mô tả";
            $strFacility = "Tiện ích";
            $strAmenity = "Nơi cư ngụ";
            $strDistance = "Khoảng cách";
            $strImage = "Hình ảnh";
        } elseif ($lang == 'en') {
            $strAllDetail = "All the detail";
            $strAskingPrice = "Asking price";
            $strBedroom = "Bedrooms";
            $strBathroom = "Bathrooms";
            $strBuiltUp = "Build up";
            $strFurnishing = "Furnishing";
            $strFloor = "Floor";
            $strClassification = "Classification";
            $strOccupancy = "Occupancy";
            $strYearBuilt = "Year built";
            $strPossibleTerm = "Possible term";
            $strPostedDate = "Posted date";
            $strDescription = "Description";
            $strFacility = "Facilities";
            $strAmenity = "Amenities";
            $strDistance = "Distances";
            $strImage = "Images";
        } else {
            $strAllDetail = "All the detail";
            $strAskingPrice = "Asking price";
            $strBedroom = "Bedrooms";
            $strBathroom = "Bathrooms";
            $strBuiltUp = "Build up";
            $strFurnishing = "Furnishing";
            $strFloor = "Floor";
            $strClassification = "Classification";
            $strOccupancy = "Occupancy";
            $strYearBuilt = "Year built";
            $strPossibleTerm = "Possible term";
            $strPostedDate = "Posted date";
            $strDescription = "Description";
            $strFacility = "Facilities";
            $strAmenity = "Amenities";
            $strDistance = "Distances";
            $strImage = "Images";
        }

        $furnishing = $property->getFurnishing($property->furnishing_id, $lang);
        $classification = $property->getClassification($property->classification_id, $lang);
        $occupancy = $property->getOccupancy($property->occupancy_id, $lang);
        $possible = $property->getPossible($property->possible_term_id, $lang);

        $html = '
            <div style="font-size: 23px; margin-bottom: 5px;">' . $propertyLang->title . '</div>
            <div style="font-size: 11px; margin-bottom: 10px;">' . $propertyLang->full_addrpossible_term_idess . '</div>

            <div style="font-size: 23px; margin-bottom: 5px;">' . $strAllDetail . '</div>
            <div style="color: #7b7b7b; font-size: 12px; font-style: italic; margin-top: 5px;">' . $propertyLang->slogan . '</div>

            <div></div>

            <table style="width: 100%; font-size: 12px;" cellpadding="6">
                <tr style="color: #006EDE; font-size: 18px">
                    <td style="font-weight: bold">' . $strAskingPrice . ':</td>
                    <td style="text-align: right;">' . $property->currency . ' ' . $property->price. '</td>
                </tr>
                <tr>
                    <td style="font-weight: bold; border-top: 0px solid #BDBDBD;">' . $strBedroom . ':</td>
                    <td style="text-align: right; border-top: 0px solid #BDBDBD;">' . $property->number_of_bedroom . '</td>
                </tr>
                <tr>
                    <td style="font-weight: bold; border-top: 0px solid #BDBDBD;">' . $strBathroom . ':</td>
                    <td style="text-align: right; border-top: 0px solid #BDBDBD;">' . $property->number_of_bathroom . '</td>
                </tr>
                <tr>
                    <td style="font-weight: bold; border-top: 0px solid #BDBDBD;">' . $strBuiltUp . ':</td>
                    <td style="text-align: right; border-top: 0px solid #BDBDBD;">' . $property->build_up . '</td>
                </tr>
                <tr>
                    <td style="font-weight: bold; border-top: 0px solid #BDBDBD;">' . $strFurnishing . ':</td>
                    <td style="text-align: right; border-top: 0px solid #BDBDBD;">' . $furnishing . '</td>
                </tr>
                <tr>
                    <td style="font-weight: bold; border-top: 0px solid #BDBDBD;">' . $strFloor . ':</td>
                    <td style="text-align: right; border-top: 0px solid #BDBDBD;">' . $property->floor_number . '</td>
                </tr>
                <tr>
                    <td style="font-weight: bold; border-top: 0px solid #BDBDBD;">' . $strClassification . ':</td>
                    <td style="text-align: right; border-top: 0px solid #BDBDBD;">' . $classification . '</td>
                </tr>
                <tr>
                    <td style="font-weight: bold; border-top: 0px solid #BDBDBD;">' . $strOccupancy . ':</td>
                    <td style="text-align: right; border-top: 0px solid #BDBDBD;">' . $occupancy . '</td>
                </tr>
                <tr>
                    <td style="font-weight: bold; border-top: 0px solid #BDBDBD;">' . $strYearBuilt . ':</td>
                    <td style="text-align: right; border-top: 0px solid #BDBDBD;">' . $property->year_built . '</td>
                </tr>
                <tr>
                    <td style="font-weight: bold; border-top: 0px solid #BDBDBD;">' . $strPossibleTerm . ':</td>
                    <td style="text-align: right; border-top: 0px solid #BDBDBD;">' . $possible . '</td>
                </tr>
                <tr>
                    <td style="font-weight: bold; border-top: 0px solid #BDBDBD;">' . $strPostedDate . ':</td>';
        if ($lang == "vi")
            $html .= '<td style="text-align: right; border-top: 0px solid #BDBDBD;">' . date('d-m-Y, h:ia', strtotime($property->created_at)) . '</td>';
        else
            $html .= '<td style="text-align: right; border-top: 0px solid #BDBDBD;">' . date('Y-m-d, h:ia', strtotime($property->created_at)) . '</td>';

        $html .= '</tr>
            </table>

            <div></div>
            <div style="font-size: 23px; margin-bottom: 5px;">' . $strDescription . '</div>
            <div style="font-size: 12px">' . $propertyLang->description . '</div>
        ';

        /* ------------------ Append Facility ------------------ */
        if($property->facilities != ''){
            $htmlFacility = '
                <div></div>
                <div style="font-size: 23px; margin-bottom: 5px;">' . $strFacility . '</div>

                <table style="font-weight: bold;" cellpadding="6">
                    <tr>';

            $facilities = substr($property->facilities, 0, -1);
            $facilities = substr($facilities, 1);

            $arrFacilitie = explode(",", $facilities);

            $arrFacility = array();
            foreach ($arrFacilitie as $facilitie) {
                $arrFacility[] = Facility::getFacilities($facilitie, $lang);
            }

            $htmlFacility = '';
            if (count($arrFacility) > 0) {
                $htmlFacility = '<table><tr>';
                $i = 1;
                foreach ($arrFacility as $faci) {
                    $htmlFacility .= '<td style="border-bottom: 1px solid #BDBDBD;"> 
                                            <table>
                                            <tr>
                                                <td valign="middle" width="30"><img src="' . $faci['icon'] . '"></td>
                                                <td valign="middle" align="left">' . $faci['name'] . '</td>
                                            </tr>
                                            </table>
                                        </td>';
                                       
                    if ($i % 2 == 0) {
                        $htmlFacility .= '</tr><tr>';
                    }
                    $i++;
                }
                if($i%2 != 0) $htmlFacility .= '<td></td>';
                $htmlFacility .= '</tr><table>';
            }
            $html .= $htmlFacility;
        }

        /* ------------------ End - Append Facility ------------------ */

        /* ------------------ Append Amenity ------------------ */

        $htmlAmenities = '
            <div></div>
            <div style="font-size: 23px; margin-bottom: 5px;">' . $strAmenity . '</div>
        ';

        $arrAmenity = $propertyLang->amenities;
        $arrAmenity = json_decode($arrAmenity, true);
        
        if (count($arrAmenity) > 0) {
            foreach ($arrAmenity as $amenity) {
                $htmlAmenity = '
                    <table cellpadding="6">
                        <tr>
                            <td style="font-weight: bold;"><img src="' .base_path().'/resources/images/icons/' . $amenity['img'] . '"> ' . $amenity['name'] . '</td>
                            <td style="text-align: right;">' . $strDistance . '</td>
                        </tr>
                ';

                foreach ($amenity['data'] as $item) {
                    $htmlAmenity .= '
                        <tr>
                            <td style="border-top: 0px solid #BDBDBD;">
                                <span style="font-weight: bold;">' . $item['location'] . '</span>
                            </td>
                            <td style="border-top: 0px solid #BDBDBD; text-align: right;">' . $item['distance'] . ' km</td>
                        </tr>
                    ';
                }

                $htmlAmenity .= '</table><div></div>';

                $htmlAmenities .= $htmlAmenity;
            }
        }

        $html .= $htmlAmenities;
        /* ------------------ End - Append Amenity ------------------ */


        /* ------------------ Append Images ------------------ */
        $html .= '
            <div></div>
            <div style="font-size: 23px; margin-bottom: 5px;">' . $strImage . '</div>
        ';

        $arrImage = json_decode($propertyLang->image);
        if(count($arrImage) > 0)
        {
            foreach ($arrImage as $image) {
                $html .= '<div><img src="' .base_path().'/resources/images/properties/' . $image->url . '"><div>';
            }
        }
        /* ------------------ End - Append Images ------------------ */

        $test = \Helper::savePDF($html, $propertyLang->title, $fileName);
    }


    /**
     * @Desc generate HTML string from input
     * @return void
     * @author Hung <hung@magiclabs.vn>
     */
    //View example at app/Http/Controllers/Frontend/PagesController.savePDF
    public static function generatePDFContent($fileName, $title, $strImage, $arrImage, $address, $strAllDetail, $strDescription, $description, $slogan, $strAskingPrice, $currency, $price, $strBedroom, $bedroom, $strBathroom, $bathroom, $strBuiltUp, $builtUp, $strFurnishing, $furnishing, $strFloor, $floor, $strClassification, $classification, $strOccupancy, $occupancy, $strYearBuilt, $yearBuilt, $strPossibleTerm, $possibleTerm, $strPostedDate, $postedDate, $strFacility, $arrFacility, $strDistance, $strAmenity, $arrAmenity)
    {
        $html = '
            <div style="font-size: 23px; margin-bottom: 5px;">' . $title . '</div>
            <div style="font-size: 11px; margin-bottom: 10px;">' . $address . '</div>

            <div style="font-size: 23px; margin-bottom: 5px;">' . $strAllDetail . '</div>
            <div style="color: #7b7b7b; font-size: 12px; font-style: italic; margin-top: 5px;">' . $slogan . '</div>

            <div></div>

            <table style="width: 100%; font-size: 12px;" cellpadding="6">
                <tr style="color: #006EDE; font-size: 18px">
                    <td style="font-weight: bold">' . $strAskingPrice . ':</td>
                    <td style="text-align: right;">' . $currency . ' ' . $price . '</td>
                </tr>
                <tr>
                    <td style="font-weight: bold; border-top: 0px solid #BDBDBD;">' . $strBedroom . ':</td>
                    <td style="text-align: right; border-top: 0px solid #BDBDBD;">' . $bedroom . '</td>
                </tr>
                <tr>
                    <td style="font-weight: bold; border-top: 0px solid #BDBDBD;">' . $strBathroom . ':</td>
                    <td style="text-align: right; border-top: 0px solid #BDBDBD;">' . $bathroom . '</td>
                </tr>
                <tr>
                    <td style="font-weight: bold; border-top: 0px solid #BDBDBD;">' . $strBuiltUp . ':</td>
                    <td style="text-align: right; border-top: 0px solid #BDBDBD;">' . $builtUp . '</td>
                </tr>
                <tr>
                    <td style="font-weight: bold; border-top: 0px solid #BDBDBD;">' . $strFurnishing . ':</td>
                    <td style="text-align: right; border-top: 0px solid #BDBDBD;">' . $furnishing . '</td>
                </tr>
                <tr>
                    <td style="font-weight: bold; border-top: 0px solid #BDBDBD;">' . $strFloor . ':</td>
                    <td style="text-align: right; border-top: 0px solid #BDBDBD;">' . $floor . '</td>
                </tr>
                <tr>
                    <td style="font-weight: bold; border-top: 0px solid #BDBDBD;">' . $strClassification . ':</td>
                    <td style="text-align: right; border-top: 0px solid #BDBDBD;">' . $classification . '</td>
                </tr>
                <tr>
                    <td style="font-weight: bold; border-top: 0px solid #BDBDBD;">' . $strOccupancy . ':</td>
                    <td style="text-align: right; border-top: 0px solid #BDBDBD;">' . $occupancy . '</td>
                </tr>
                <tr>
                    <td style="font-weight: bold; border-top: 0px solid #BDBDBD;">' . $strYearBuilt . ':</td>
                    <td style="text-align: right; border-top: 0px solid #BDBDBD;">' . $yearBuilt . '</td>
                </tr>
                <tr>
                    <td style="font-weight: bold; border-top: 0px solid #BDBDBD;">' . $strPossibleTerm . ':</td>
                    <td style="text-align: right; border-top: 0px solid #BDBDBD;">' . $possibleTerm . '</td>
                </tr>
                <tr>
                    <td style="font-weight: bold; border-top: 0px solid #BDBDBD;">' . $strPostedDate . ':</td>
                    <td style="text-align: right; border-top: 0px solid #BDBDBD;">' . $postedDate . '</td>
                </tr>
            </table>

            <div></div>
            <div style="font-size: 23px; margin-bottom: 5px;">' . $strDescription . '</div>
            <div style="font-size: 12px">' . $description . '</div>
        ';

        $htmlFacility = '
            <div></div>
            <div style="font-size: 23px; margin-bottom: 5px;">' . $strFacility . '</div>

            <table style="font-weight: bold;" cellpadding="6">
                <tr>
        ';

        /* ------------------ Append Facility ------------------ */
        $count = 0;
        //Find last row index
        if (count($arrFacility) % 2 == 0) {
            $lastRowIndex = count($arrFacility) - 2;
        } else {
            $lastRowIndex = count($arrFacility) - 1;
        }

        for ($i = 0; $i < count($arrFacility); $i++) {
            $item = $arrFacility[$i];

            if ($count == 2) //2 items per row
            {
                $htmlFacility .= '</tr><tr>';
            }

            if ($i >= $lastRowIndex) //Last row => don't insert border-bottom
            {
                $htmlFacility .= '
                    <td>
                        <img src="' . $item['icon'] . '"> ' . $item['name'] . '
                    </td>
                ';
            } else {
                $htmlFacility .= '
                    <td style="border-bottom: 0px solid #BDBDBD;"> 
                        <img src="' . $item['icon'] . '"> ' . $item['name'] . '
                    </td>
                ';
            }

            $count++;
        }
        $htmlFacility .= '</tr></table>';
        $html .= $htmlFacility;
        /* ------------------ End - Append Facility ------------------ */

        /* ------------------ Append Amenity ------------------ */
        $htmlAmenities = '
            <div></div>
            <div style="font-size: 23px; margin-bottom: 5px;">' . $strAmenity . '</div>
        ';

        foreach ($arrAmenity as $amenity) {
            $htmlAmenity = '
                <table cellpadding="6">
                    <tr>
                        <td style="font-weight: bold;"><img src="' . $amenity['icon'] . '"> ' . $amenity['name'] . '</td>
                        <td style="text-align: right;">' . $strDistance . '</td>
                    </tr>
            ';

            foreach ($amenity['data'] as $item) {
                $htmlAmenity .= '
                    <tr>
                        <td style="border-top: 0px solid #BDBDBD;">
                            <span style="font-weight: bold;">' . $item['location'] . '</span> (' . $item['sub_amenity_name'] . ')
                        </td>
                        <td style="border-top: 0px solid #BDBDBD; text-align: right;">' . $item['distance'] . '</td>
                    </tr>
                ';
            }

            $htmlAmenity .= '</table><div></div>';

            $htmlAmenities .= $htmlAmenity;
        }

        $html .= $htmlAmenities;
        /* ------------------ End - Append Amenity ------------------ */


        /* ------------------ Append Images ------------------ */
        $html .= '
            <div></div>
            <div style="font-size: 23px; margin-bottom: 5px;">' . $strImage . '</div>
        ';

        foreach ($arrImage as $image) {
            $html .= '<div><img src="' . base_path() . '/resources/images/properties/' . $image['url'] . '"><div>';
        }
        /* ------------------ End - Append Images ------------------ */

        $test = \Helper::savePDF($html, $title, $fileName);
        // echo $html;
    }

    /**
     * @Desc export HTML string to PDF
     * @param String html, String title, String fileName
     * @return void
     * @author Hung <hung@magiclabs.vn>
     */
    public static function savePDF($html, $title, $fileName)
    {
        // create new PDF document
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Baodi');
        $pdf->SetTitle($title);
        // $pdf->SetSubject('TCPDF Tutorial');
        // $pdf->SetKeywords('TCPDF, PDF, example, test, guide');
        // set default header data
        // $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 006', PDF_HEADER_STRING);
        // set header and footer fonts
        // $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        // $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        // $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        // $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        // $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetPrintHeader(false);
        $pdf->SetPrintFooter(false);
        $pdf->SetPageOrientation('Portrait');

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
            require_once(dirname(__FILE__) . '/lang/eng.php');
            $pdf->setLanguageArray($l);
        }

        // ---------------------------------------------------------
        // convert TTF font to TCPDF format and store it on the fonts folder
        $fontname = TCPDF_FONTS::addTTFfont(base_path() . '/resources/Fonts/Arial.ttf', 'TrueTypeUnicode', '', 32);
        // use the font
        $pdf->SetFont($fontname, '', 11);
        // add a page
        $pdf->AddPage();

        // output the HTML content
        $pdf->writeHTML($html, true, false, true, false, '');

        // reset pointer to the last page
        $pdf->lastPage();

        //Close and output PDF document
        // $pdf->Output($fileName, 'I'); //Show to browser
        // $pdf->Output($fileName, 'D'); //Download
        $pdf->Output(base_path() . '/resources/pdf/' . $fileName, 'F'); //Save file
    }

    /**
     * @Desc export HTML string to PDF
     * @param String html, String title, String fileName
     * @return void
     * @author Hung <hung@magiclabs.vn>
     */
    public static function savePDFInvoice($html, $title, $fileName)
    {
        // create new PDF document
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Baodi');
        $pdf->SetTitle($title);
        // $pdf->SetSubject('TCPDF Tutorial');
        // $pdf->SetKeywords('TCPDF, PDF, example, test, guide');
        // set default header data
        // $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 006', PDF_HEADER_STRING);
        // set header and footer fonts
        // $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        // $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        // $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        // $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        // $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetPrintHeader(false);
        $pdf->SetPrintFooter(false);
        $pdf->SetPageOrientation('Portrait');

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
            require_once(dirname(__FILE__) . '/lang/eng.php');
            $pdf->setLanguageArray($l);
        }

        // ---------------------------------------------------------
        // convert TTF font to TCPDF format and store it on the fonts folder
        $fontname = TCPDF_FONTS::addTTFfont(base_path() . '/resources/Fonts/Arial.ttf', 'TrueTypeUnicode', '', 32);
        // use the font
        $pdf->SetFont($fontname, '', 11);
        // add a page
        $pdf->AddPage();

        // output the HTML content
        $pdf->writeHTML($html, true, false, true, false, '');

        // reset pointer to the last page
        $pdf->lastPage();

        //Close and output PDF document
        // $pdf->Output($fileName, 'I'); //Show to browser
        // $pdf->Output($fileName, 'D'); //Download
        $pdf->Output(storage_path().'/pdf/' . $fileName, 'F'); //Save file
    }

    /**
     * @Desc escape single quote (Replace ' with \')
     * @param String str
     * @return String
     * @author Hung <hung@magiclabs.vn>
     */
    public static function escapeSingleQuote($str)
    {
        return str_replace("'", "\'", $str);
    }

    /**
     * @Desc get distance between 2 points by their coordinations.
     * @param Float $lat1 , $lat2, $long1, $long2
     * @return Float distance in kilometres
     * @author Vu <vu@magiclabs.vn>
     */
    public static function getDistance($lat1, $long1, $lat2, $long2)
    {
        $unit = 10000 / 90;
        $distance = $unit * rad2deg(acos(cos(deg2rad($lat1)) *
                cos(deg2rad($lat2)) * cos(deg2rad($long1 - $long2)) +
                sin(deg2rad($lat1)) * sin(deg2rad($lat2))));
        return $distance;
    }

    /**
     * @Desc cut word if > than length (replace with ...)
     * @param String string, Int length
     * @return String limited word
     * @author Vu <vu@magiclabs.vn>
     */
    public static function limitWord($string, $length, $getWord = false,  $charset='UTF-8')
    {
        if ($getWord) {
            $str = html_entity_decode($string, ENT_QUOTES, $charset);
            if (mb_strlen($str, $charset) > $length) {
                $arr = explode(' ', $str);
                $str = mb_substr($str, 0, $length, $charset);
                $arrRes = explode(' ', $str);
                $last = $arr[count($arrRes) - 1];
                unset($arr);
                if (strcasecmp($arrRes[count($arrRes) - 1], $last)) unset($arrRes[count($arrRes) - 1]);
                return implode(' ', $arrRes) . "...";
            }
        } else {
            if (strlen($string) > $length) {
                // truncate string
                $string = substr($string, 0, $length) . '...';

                // make sure it ends in a word so assassinate doesn't become ass...
                // $string = substr($string, 0, strrpos($string, ' ')).'...';
            }
        }
        return $string;
    }
}
