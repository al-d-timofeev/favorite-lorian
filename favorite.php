<?
    require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
    header('Pragma: no-cache');
    header('Content-Type: application/json; charset=UTF-8');

    use Bitrix\Main\Context;
    global $APPLICATION;
    global $USER;

    $request = Context::GetCurrent()->getRequest();
    $id = $request->get('id');
    $action = $request->get('action');
    $result = array();

    $rsUser = CUser::GetByID($USER->GetID());
    $arUser = $rsUser->Fetch();

    if($action == 'add'){

        if ($USER->IsAuthorized()){
            if(is_array($arUser['UF_FAVOR'])){
                $array = $arUser['UF_FAVOR'];
            }else{
                $array = array();
            }
            $user = new CUser;
            array_push($array, $id);
            $fields = Array(
                "UF_FAVOR" => array_unique($array),
            );
            $user->Update($USER->GetID(), $fields);
        }else{
            $favor_cookie = $APPLICATION->get_cookie("FAVOR");
            if (!empty($favor_cookie)){
                $favor_cookie .= ' '.$id;
            }else{
                $favor_cookie = $id;
            }
            $favor_cookie_array = explode(' ', $favor_cookie);
            $APPLICATION->set_cookie("FAVOR", $favor_cookie, time()+60*60*24*30*12*2);
        }

    }elseif($action == 'remove'){

        if ($USER->IsAuthorized()) {
            $array = $arUser['UF_FAVOR'];
            $user = new CUser;
            foreach ($array as $key => $item) {
                if ($item == $id) {
                    unset($array[$key]);
                }
            }
            $fields = Array(
                "UF_FAVOR" => $array,
            );
            $user->Update($USER->GetID(), $fields);
        }else{
            $favor_cookie = $APPLICATION->get_cookie("FAVOR");
            $favor_cookie_array = explode(' ', $favor_cookie);
            foreach ($favor_cookie_array as $key => $ck){
                if ($ck == $id){
                    unset($favor_cookie_array[$key]);
                    break;
                }
            }
            $favor_cookie = implode(' ', $favor_cookie_array);
            $APPLICATION->set_cookie("FAVOR", $favor_cookie, time()+60*60*24*30*12*2);
        }

    }






    if ($USER->IsAuthorized()) {
        $rsUser = CUser::GetByID($USER->GetID());
        $arUser = $rsUser->Fetch();
        $result['cnt'] = count($arUser['UF_FAVOR']);
    }else{
        $result['cnt'] = count($favor_cookie_array);
        $result['id'] = $favor_cookie;
        $result['id_array'] = $favor_cookie_array;
    }

    echo json_encode($result);


    require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_after.php");