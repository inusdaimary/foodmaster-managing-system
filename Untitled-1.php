<?php

header('Access-Control-Allow-Origin: *');



// --------------Connection Start--------------------------- 
function getConn()
{

    // External test env
    // $dbstrEx = '(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=172.16.20.102)(PORT=1521))(CONNECT_DATA=(SID=hms)))';
    // $unameEx = 'test';
    // $passEx = 'test';


    $dbstrEx = '(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=172.16.20.102)(PORT=1521))(CONNECT_DATA=(SID=hms)))';
    $unameEx = 'gnrcn';
    $passEx = 'prod_1985_ngp';

    if ($conn = oci_connect($unameEx, $passEx, $dbstrEx)) {
        return $conn;
    } else {
        // $e = oci_error(); 
        // return $e['message'];
        return null;
    }
}

function getConn1()
{

    // External test env
    $dbstrEx = '(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=172.16.14.151)(PORT=1521))(CONNECT_DATA=(SID=hms)))';
    $unameEx = 'test';
    $passEx = 'test';


    // $dbstrEx = '(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=172.16.20.102)(PORT=1521))(CONNECT_DATA=(SID=hms)))';
    // $unameEx = 'gnrcn';
    // $passEx = 'prod_1985_ngp';

    if ($conn = oci_connect($unameEx, $passEx, $dbstrEx)) {
        return $conn;
    } else {
        // $e = oci_error(); 
        // return $e['message'];
        return null;
    }
}
// --------------Connection End--------------------------- 

// $data = file_get_contents("php://input");
// $req111 = json_decode($data, true);
// var_dump($req111);

// // echo json_encode($req111);

// exit;


$conn = getConn();

$x =  json_encode($_REQUEST);
// $text = $x;
// $filename = "file001.txt";
// $fh = fopen($filename, "w");
// fwrite($fh, $text);
// fclose($fh);

$myfile = fopen("file001.txt", "a") or die("Unable to open file!");
$txt = date("d-m-Y H m i") . " " . $x . "\n\n";
fwrite($myfile, $txt);
fclose($myfile);



switch ($_REQUEST['req_type']) {
    case 'validate-user-session':
        validateUserSession($conn, $_REQUEST);
        break;
        case 'get-subordinate-attendance-report':
            getSubordinateAttendanceReport($conn, $_REQUEST);
            break;

        
    case 'populate-attendance-data-for-auth-request':
        populateAttendanceDataForAuthRequest($conn, $_REQUEST);
        break;
    case 'auth-attendance-request':
        authAttendanceRequest($conn, $_REQUEST);
        break;
    case 'insert-attendance-request':
        insertAttReq($conn, $_REQUEST);
        break;



    case 'insert-sm-attendance':
        insertSMAttendance($conn, $_REQUEST);
        break;
    case 'get-sm-attendance-data':
        getSmAttendanceData($conn, $_REQUEST);
        break;
    case 'get-sm-wise-revenue-breakup-app':

        $curlHandle = curl_init("http://10.0.3.8/swasthyamitra/api/1.0/index_test.php");
        curl_setopt($curlHandle, CURLOPT_POSTFIELDS, $_REQUEST);
        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);

        $curlResponse = curl_exec($curlHandle);
        $data = json_decode($curlResponse, true);
        curl_close($curlHandle);
        echo json_encode($data);
        break;

    case 'verify-survey':

        saveVisitTagging($conn, $_REQUEST);
        //  echo json_encode(["status" => '0', 'message' => "TESTING ERROR"]);
        break;
    case 'pull-survey':
        getSurveyData($conn, $_REQUEST);
        break;
        // case 'auth-user':
        //     authLogin($conn, $_REQUEST);
        //     break;
        // case 'auth-user-1':
        //     authLoginV1($conn, $_REQUEST);
        //     break;
    case 'auth-user-2':
        authLoginV2($conn, $_REQUEST);
        break;
    case 'auth-user-v3':
        authLoginV3($conn, $_REQUEST);
        break;

    case 'logout-user':
        logoutUser($conn, $_REQUEST);
        break;

    case 'create-family':
        createFamily($conn, $_REQUEST);
        break;
    case 'get-family':
        getFamily($conn, $_REQUEST);
        break;
    case 'get-state-list':
        getCommonData($conn, $_REQUEST);
        break;
    case 'get-district-list':
        getCommonData($conn, $_REQUEST);
        break;
    case 'get-news-feed':
        getNewsFeed($conn, $_REQUEST);
        break;
    case 'get-wallet-transactions':
        getWalletTransactions($conn, $_REQUEST);
        break;
    case 'set-reedem-request':
        setReedemRequest($conn, $_REQUEST);
        break;
    case 'get-wallet-balance':
        getWalletBalance($conn, $_REQUEST);
        break;
    case 'get-wallet-summary':
        getWalletBalance($conn, $_REQUEST);
        break;
    case 'get-reedem-requests':
        getReedemRequests($conn, $_REQUEST);
        break;
    case 'get-symptoms-list':
        echo getSymptomsList($conn, $_REQUEST);
        break;
    case 'save-survey-test':
        // saveSurvey($conn, $_REQUEST);




        //  function pullDataFromLiveServer($conn, $reqData)
        //   {
        // $postParameter = array(
        //     "reqType" => "getSmRatioData",
        //     "dataDate" => $reqData['dataDate']
        // );
        $_REQUEST['reqType'] = 'save-survey-test';
        $curlHandle = curl_init("http://10.0.3.8/test/api_controller.php");
        curl_setopt($curlHandle, CURLOPT_POSTFIELDS, $_REQUEST);
        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);

        $curlResponse = curl_exec($curlHandle);
        $data = json_decode($curlResponse, true);
        curl_close($curlHandle);
        echo json_encode($data);
        // if (isset($data["data"])) {
        //     $token = time();
        //     saveDatatToExtServer($conn, $token, $data['data']);
        // } else {
        // }
        //    }

        break;

    case 'get-training-mcq':
        $conn = getConn1();
        getTrainingMcq($conn, $reqData);
        break;
    case 'get-training-videos':
        $conn = getConn1();
        getTrainingVideos($conn, $reqData);

        break;
    case 'get-notification-schedule':

        $conn = getConn1();
        getNotificationSchedule($conn, $reqData);
        exit;

        $link1 = json_encode("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ALEyw/PINF2FBiJLxnuqF5w6AKLbI/0f//NExIEdyxqcAMlQvH////S8t//8W3lLz///+/D1HM+VHL/r/z/lv9XNhKc8QGXRl4SMzMFpdnHicoWIxAQDp+l5AvttF13CuI4nZOaSG25CSQpNoJJCtKMcQExgn5O8//NExFwY6xqsADhSvVIaQuSIFWx9OUmBAJFn6EPVS////Ki1X//92b///9P//frylmdA8dnLNylZSvMAwBCRxz6qHSkcyB0PKIjjsYwiHRxlDqOYRHGcRDrGY0PGhJLS//NExEsSOwq4ADhKucUHeC7a7YDcpmMEsbMKVRTsNxfVdrEI7MAKG2KGJIu1OejkI8BwEFAB4nQTuuU8u8HyIOHCC9t+Ajn////0Mv3VdHTVxrN1M3dWGnYQWjvZCoJf//NExFURSK6sAMYQTCl823QeoRjLNomegBdjF5bSsf0UpIB6JCHgR3oHnNRy76damDgeKJAKCir6X/+caNIUcACFSo9SukcwEVg5Am0LGo1XCgaeygmQ2ybLltsOmLCO//NExGIRGY6wAMpKlMLWFeD/i3//ozW67QnTA9i1crO1DG++NAUrh4pW/+5VeRFIRhYcLyv7gXcNn5HMShogDJBRdogyDeTNscJYmaMVHo4+gCic9v/9/u9jrVOusrs9//NExHAReZKkANPKlWXRVmmsisj9r/7XLzOoIUWOob23f////31PFKVNR6jABFOaCkYBKnRiMJBAQcsKhIx+CKc6RNS87HaIy+UoKVGyMU8GVDreF/IaRM12E0AnEUjo//NExH0RcYqcANLElNR7/rUsFQEsBJuljyP/////j6loFMyIEnQBJLoTRINDPT0Vnsdbq45f/5b/lsCNqJPehLRZztRC8gXPuaJyjUiAuH0qGqLghixznFJIfRsn//////NExIoScMp4AOPEcFoqhMYAU9mpFpfru1aO5Um/7369utQ+fR0ezy7fvBZHrepkU0P+5dQ2GXi1yvP/DsT02oYpEu0qo6U9vK1ASVjWmkS+oVnIlU4LRTzfDIMiRV85//NExJMQKG6EAVgIAB4kY2UWGUUVXVc/LIV0p1nMNICNcNsQogjizclpopxtmutP+5+9qvVZ9/6DaKvN6wwgwxb6D4O1faEaz5uI9mQ+upi2xfX////0gc6giEav4lv///NExKUhoyp4AZhI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");


        $link2 = json_encode("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RAOFBx+QWM06EAICwbnh2Kj4HDxQOB1qL//////+f////////////6tzfZ3dqobp//NExBgRaxrMAAhOvSrA+eWQfnFCyOQKHuUYfkRO4rGwZHhMPjhY0ShoMD48cQHyA3EgCgvFpyg9PTIP///////Bl//////////+h25zKvfurmKrtLmnsPjxqmSBh5g0//NExCUSqxrMAAhOvRkfQbrHj0EsauTJOK0LCtRYPjdh4JhaNg8YGSJNg4XCofF0RSMtI8ZBYJrfP/P//5HRLL/+/5n///2v/1+pk/3ZWMY2xWQwkZzYtVklKHUMZ0NM//NExC0RGx7EAAhKvGMg8hhYpnElDrNRWYxgGAwsjocih1BYqpu5/xMwtBeQoCeWW4BUUHHxLH/lABxissEGP1Lp3wf1MUMSodln/pf//+Po+7f//vpTr////vuxEX+///NExDsScu6sAMoEuOj/fp7tZZlW8yIiAz52ZqbW5p2TLyIhXu1MJoALqzqX9zbtfz9AglH/tP/8a/Z1kUYMOGJDxZulnpMCyP/aoKjf/ooN+1KJhV6Ff8KgYSESSUXX//NExEQQqMKwAM4MTO+sjB2YRPfKHKa9PflvHH/mv/fIj/////////1//bXpbZO90z+nZypVanmIYUMqFQjCEP3eIFHhx7AOMZBgoLxdg5VBRFZyoEoUp3t/////p/////NExFQRgx68AMBKvP////+v2/X/76tW19EU1FrsYmpinHFSrEnOU09JZnMPcq55o4PmkHYkaeNRaL1OIDsmGRMYJIuHTnGPleIyIGoOux+K/De/vejwXkIRX2PrrnOr//NExGERwyK8AFBOvIIbZz/X//2ev///+v////3/6IYrf1aZSlZlKWUqGNUpVoGNcpZuZ1CgqJWMdxTLDXnmj5IAYzqlznKGGgDjWsY9dywmKtncTl1rdPhll7k0eI5t//NExG0REwa4AHiEuRAeCcBohgsLmXSEThP+KrjeS3M7PIGG/6lKCf/////VQxHol1WVJgjWqrpiOiA6Wq3lkgptjK2VhLPar1h9PO922tsXWkNRZYB0AAMlVxXbNZtl//NExHsSwS60AM4QcP4/b+HaSuFf/tIhsBF11f7V0f///+h939U6N8hpTSUJKarpUS+S8Ly1Z3+XZVLss7PP1lod7KbOOOx0FwOnS2n837I6DZjv///9TBsNiThX6vI1//NExIMRgSq0AMMMcBMSrcm3kb/8ipU60eHicJUxIXNvDENh4bpE1Lcfxu/jX/TKpxU676qMvia7HAOEgte69+fHrUEg0aSKZV/uwUm0owFSultJX3/owNgVWcxINRlm//NExJARkaqkAVg4AKoNSxaYpIRLqKFWBuC1w5BqqjN6eK0K4vpXq7jSezhcaaISFW0io2ivX9omlh2mP7PjBYxBHVdMZdwPaS3/tGEj//JuSzvcELC/iMempmCdjqQE//NExJwfswJQAZtAAT+6mW5IMX/20FudTaamnfTQW+58zMSQNjQwEsVqrVZTKQZukdE8MTQeRImwXeh1X7rTddN2T1CNlQT8OMSwOQCSDIFwC4DcCqVer991rufTshs2//NExHAgayqMAY9oADwNBlgjgThAWAXAkDyx5jMFggcHmOdG06+3GyCRdtuenOjd//5bv26///jx9dlr/KqEMq78a+b4TquuzHa+//+459xOv7xptWKTGRyeVNXNrblG//NExEEf4x6wActIAA/WDaSKiYQnmgNEYpQmUAnKNsE6iRkLA0krceMzCrJNQp1RpOZgVIkMiocZV6TyIqhyS0pocjlqsLak1sSFqiSxW9bJ4lI993xZvwxPhpsF6dZO//NExBQWsg6oAHmEmbNe+27rtut+/uQUiaDkkHuCabOtXTawkUGChDdNkX/VjGQYpwShWMZ39PujlJWUsCFAqKFrJ9CVXXhTeV/vzFhxr6Tf//1ux+ym6fscboqZIR87//NExAwQaS6oAMvMcF1tV+IaYEwZtwiQIGSIu7/f1vFw6DNP9xHoEWejETlbmbDv/3joek2QAptIpW93i8AOb/+zRYAxmiwKYUlPSdISFa+8gte1flwwldTmSylWWtSl//NExB0RsSKsAM4WcNC137t/O3w7yRNWKiSXpIE97Xq3247TrWj3tqEjehUOSXyVVw5bRrv/pafDOGDteMXeKVrevdYQiKt2QaBed0IwcP/Rcb5a8eog1qGY1eSQWaTH//NExCkRoSawAMPacMmV1vqP11ara0UjNwkfors4uBSYMk1f/1PR///+tYVn9o71qvbpIW0P/fBFG9uCAqqetewpm9/mcYvc7d79B13Zxy8A4jsRVRm5tZz99ELnqNhu//NExDUSWTKoAM4UcMXusnqIBW1b/+uJ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3fel4ukn4W+ot+O/2KsSYWOJHjC47aKq//NExKYXuZ6cANvMlN3i7nqUU8VIGkG//9////9F7iZBfnTGTM+f+GCR5ak+0sWWl3CAr86gtAFLZhEBvs2iMFsv+wOYjbiyL1AVGpE5Ltob///TmmsQkswfHCENj12w//NExJoWsZakANPQlBKkaf//////sFVKfuPpOGoqv5LTKgR5D4qhJi1aqXak/WiyOu3Rr9N1a1JbUVFjT2MSteCNQuunb///1dXB7i1xF7FnWnFf//t///7aYlpA5ylK//NExJISWTqkAM4UcM6Fmaewkdk0mXlChiCQKhqrgse9a4q80htuUkA/5JkzrOcR/wT0f9de/1/6OU4g+ec7qbJHSwgaOAv/2NeTRd///lI1L4tVZw5aNh9y2tBrZhCy//NExJsQ4TKYANYEcAJbewRApowDbVAtxSTIkdjMygzST2F1DfQ9JKdntVnu4pt9Gpqmi//9DmglPdawf9P/70zFZqz///R3qeRFlYYcdGQ4dQQMpxAIkoF2UDpFL7rI//NExKoSiSKMAN4EcOwhlgobgwJECYGYjwXIDIcDUMgKyCuVWdyiFX/X7/p/nuHHPh41AaQhj3vf/9SpJ45e////+imCYaVRMpnRTnoBFjv2Etnbpr0GoiShrKVzNNTC//NExLISkSqIANvEcL2jmUBLDIlARIWFSuUgAyuKZ+zUP//d0orocQF0FxShRdBV4scQLAMeIBX/dfqWk4A1fSzFjAgnFOyRCqxhHhYW6ssL8yjTIRMFiNFREOVoyOLV//NExLoSwSqUANvEcKLUlIiU34Rv+67+v5/65//ftrqSkJEdSmsL2Y+NmGHFhECkWv0fts7kKndnXwEURrU3To21cvShs8lSbMazUMFo4ywcZSz2THU+ZdYQWxw5GO73//NExMITYUagANYKcGsf1z/7z6dunbVqDOA7PDxsjTmoJsGWkj5J39b11Vw2YcNGIrUkVlKq3nHE463XxZN2CkKma9T3HrObQrTNpp16y2aItFNgHCGiDf1qEWXteb+K//NExMcSiX6kAMYKlK0/dSKakHrmzgmg8ii4del30GKTkbFJ6kZp2CILygQmN92A2DT0EAwSubK+CJNuUsrdqN2xCdEV9U65ZahiQ2aSk3jXy/Xb2XWPIr1aGEg1DHn///NExM8RiWakANYK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//NExJgh8yqAAZhoAO0+tpnZmd+lHVMFqMlI4Lp/AhDzFSi/s21Hq6+W0d9s8+uTmZRyy5dGEpzA0y17Dax6yv/tb/Q4Yq3Yfhsr2q3ovpO/n1/X53+vboE59Wy6O+wR//NExGMhUxKwAYhgAbT2M3zOpSF9xxiZ9imt/0y41xyngx/9t21mXbNatrA+yPbqAKogBAA8I4Ue5Q67Z/uq5r/+1RgdMJB4VCg+FgRyiKgoqInMFgWYqG7fl+VmylUY//NExDARWWaoAcgoAAEDIsPuWdWAnsUx1HDXERb/LBQ98rVjrUGZGvxuAhUYB0b4EgOHChsmgkNWESrL98ugGRPLQ9A8FcbIucKc02l6iFRpSnOxSF3LG8bAvClZzrAg//NExD0XqXqMANPUlE8MOA3iqImTsIc+7fonTsnfocYWZDFk7xeQGIb/9wvicPpj863UUql2BQWLStOQ7AJ+MUxhJKuvqGP7VXiHxJSjS1YSszli129Zh5Sr/ZIF9WJ0//NExDEdUjqcAMvKuNxQqwuAhyss91U91I3s879/uAr1fHvcYHCHOc+d8izFF1MNFA4NEHAQJi4HKLvV1/5P/ulUFCFFHY7OKODDP//yiBZyaoezbAah0k2SNobkeIhW//NExA4RuQqwAMPScOgiWNndii7Zvds3Zsi18X2V3pbKSOLi7oLTZrbzyRTqmoFmhDSw48mp/XdEoTSs7//8sIpI9///0W8uvUHumKF/HOsPA8342vwu7IFGJLIZldN0//NExBoRwkKwAMCEuFfjkdWY3/8vofQZG9v//ffb//+c/nO+nXQiEEEKFxA4ot/hgoUcGMTisPwsAwsgeFhErWT/////7////T////3//00aySUcnuSpqPFhQODBALME//NExCYSCwLEAChKuQcpzowm5A4IFnOYhA4HBQRDgWLIKOpxdUMKOH6MzDwcJM0qH/////972//b27FYxnnORjKqKpiznQPA5zCByEIYwKEBgmEIPERAeLCkODw6Q7jj//NExDAP6xrIABAKvLmBEFBIFARBMXGAKhwmJ00S//////////f+31v2//7f/9n83rZt//+GKpquj5wwUsgTIiSziIKUchIOBJkSRi1ZHBnJQ+gTJGkhae4ZhKQVJiqo//NExEMRgx7IAAgMvBYgyAL//////kUv///P////rur0/r8kr2cpD2IV0YWYVdSTioiQokY4qURIo0QD48JOZlQRgUo4XHKHjHHGMdHOHR0qkDqIIh1hgtFqIvMJQTLe//NExFASWxLEAAhKuTL53f27ZdF7M9/7517Aysjo/pp9VSxkdf//+ULVDdP+bQ1q31cpQEBMoDp0r+WCrlHnrALuBXfLPI2F3qoNljT7MOJRUNn9UPNMcciWJ4aloynO//NExFkP6g60AGCEmDiPjka6ZhRswGSfXUX4gFli4Axq1h8yj1duiB3kQTJGiDhvX7DTR4wCvc1yVWpWZeailD5BNgm0v6OLByFa1CdLPqI4ls7MfGOasLTc4/ClrZqU//NExGwRUOqoAMvScPE451Y8VA+KaU5VOVmqDXr0aNuU7/vWHVAqISTLckpXErWwIuTSomIgRviLQIcArMasuEMONxhLsUu2T5KamQ/3Ha8S39SQrKosqLckqMFuJusN//NExHkRGPKkAMPecBZBKFAZbhUn7n9vHjNur/JDP9VvZUz02cFJngVBAZ3MKVlV+3FZTgmDqOT826KdIUhnel6SpuFGZFUzVPRWvDcGKlNCTiEl4Oc0lc9mfCpA5+j///NExIcRuOKYANPwcHKidYMKYpEFGz+OTrgwKMCz0pEY5exqbQBrg0YinDljJwfKzAYTeVU00OrA0xoDs5ORcSTwcx8Vkl0rGVC1NLu9Jf/1oDqg6V///////0OTVe1J//NExJMRGM6cANPecJQEtWND6PL9XgkodJIgjyCZcqGmjmUUY4/EQqZtDGyFCVAUEkbKyYStCgsmarXSeMklk0OYhX///+rZ77P1vgFTy59tKge4j4sQcAhhYA5wjcIg//NExKESuNqYAMvYcOWMngsJZPjWOPHldfxjl9MnfyIcwEwmkCKJk1E6QQ2U9PTaIy09IFAGaBStVruzsp7LmXmEb9Cb27u72tWxtg4VaqhFT5htXJyRbaDA4DZFRTYc//NExKkR2KaEAMPSTKEIo6Y02iAudBhyVgA5lSMAZqWLuQ9YXBttDYhDtraXBgONUNxJE2wj7Qw0wWZekim3FSJWPDVLmxrSzIhCvuXCZ4p3xTMQUzMkzXIhDnOQpXIQ//NExLQUaP6MAHsMcLyaa///2bo3fV8gjYy0qnYphgAf6q14eLWgR+ZUsIzaSiMZYWEQqKkSKtIfV6OdYj/UOlmC9nlaXVznyem2tpUYGGGDVIlz4WKEkEALDBOJS0H1//NExLUcKkKYANPEuMxSfP//19fePiH1GYcS7/+too/1poy+gxZGqABRcAw2taw+jV77P3Wl6la9Y46vyh96s3Gr7BqRHaaLZo4l1nvJVQohLg2AUZIntOtfJyViosrJ//NExJcWMaaoAMPQlLfaSINPa1nqyJWWF00QwGcsjcYihVNAhrT1GkMEJ6KKCRHhLBU6+2kFygrxLquOwp0hoxTlnY1OySXewlI1MUVtYS4DwSquVTpQIxxVqmL8rXNt//NExJESqRqsAVhIAGVPpltb1PFZFZqkBsjI1AxNf6r3mMf/4ti/9/n41//e7yBT//xd6i/4///xSm8f+v3aZzS7iThCbAn+/+qrAIW2+7ESNFMn/D20x35bApGdTdtx//NExJkgwiqgAZl4ANaXO9b3F4e4znWZ1HeGYlP34pHEcuGng5CAjyjdJR6OPRWMSSJ4GmZLbs83+t9et+70spuQFEQGiVP/7VKVjbcjG2dZAoRj0w4qrXUFjIyk81bE//NExGkU0YagAdhIAFkMaIN6G1lpz43hl3DdXgfE2rzZgeSmYmYMxYEjBoFKQhfAdhlMyPzO2wTTXvoZdqV5/Vb7976+OFAVHnTZL/1Cb6eliz5A78mFa2C2o2mSgTmS//NExGgWMX6QAMvSlOnKyqXPN60I3ZaoTqE4UjbzN86m9KxbvTs2pLMXN5i9aCKOpidsliXlcZ5hiSIYTyjEoNQGUKjNIe3///6b99CKNhGIaScAhx208LH805Wryp/v//NExGITuSqQAMvYcBIDMweIAwuiyv///2NNMZSIPRgNiMIw0cRig4I5w8HGiSJDGqrURf/+Vcu5n//82rUoy1GZkYGpG54whU0GGV6U/YYq4/CwxQFHDw8giKmO3/96//NExGYRuY6YANFOlPZkeseJsaBxE4sWOYkOhEEUUEZYo91//5rISLLOp////kkvT9CIwQZvB2iNFLguTEEvpR81dCijrthV8wIixlc1+qKypVvelLOwpMFwPlNE5F0j//NExHIQ+Y6MAMlOlKHFhgOkwLXizqDB51////0IfLbvYu2wUVVAOANDyRAJF88R/WoCRrG/CiWqqex8flLzat+RcRFVDodFStMNHAELRj1aUyFIaDssHstLJX61IGKR//NExIERmRqAAMoOcCW3UHa7qh9z/kYx6QK5bmNZxDtmD9WE+WWLk5V91Zpqo5solU0VE/4T+mu79v4tBV/H4VjtNdw1zf/v/Cydrd0tSpBddr9tuv+D28tumNZ+rm5Y//NExI0RgR5sAGDKcFiDKhQmsWhwqtWt2rR68F0PDpFVus556vSI6Z0zQwRMdASlgUasr6WecVJVqxcMQ+scanFBEBvjEm1tD68ct72uQLRR5t6XigGqI+uO7si5LK1N//NExJoSSNZEAHhEcayv9Ksty/ff96rtHmOGhdg8Mxek4vdKqWCxx6umZoFEalCjDoccWewUDiYOVmxEWFGzr4TdDRqpLWKeGWQmFLAghhwmgTcfHzieywnF2Ia0VaYZ//NExKMRkN44AHhGcKHIRq5BgrA74XqUKNUzFnnqBQ4oaoUcLhg8hJgABga8XBBQ5RqHyBsmYoMJBABaR/dnmR4xoLtb0ot/nkfcUnMzmc7X3090+6dvVGT/1pWVFurM//NExK8RQNo0AMBEcOW12dVqYE5YhaO+lfL3EnqWI7Radd+raoy/9R2sJumi4gQIAA2lSqb46lCVjhU5VAbfGh8EKGZs+IXNbSuoowpao5PpE77wXNDnJDpoyOFViNxR//NExL0QwCo4AGCMACKEKEsJVCiU3IU0BtU9HjZy5Xn98wta/8bizzb+n+dCkWqAnKXqVmKVivu/TL8imfSr6r+qwjNdQdGKmxl0QVIRDPe3RrFXISMpu9JlEx6bO+az//NExM0QegY8AGhEmTKM0VRXwaU8gz9AsbfGzvUVBPixDmWaH8qNvXuMU/+LVd6UelmepbWoIGwWR1Rj0QzWY3w5MzPe/+Znaett9jvmepGW9aZWXHM0BTIoZIzzxRmG//NExN4QYCo8AGGGAGV4ZPqpIuU2cTCmWYGu2MM+Sf2yyinQw3B0NkZonYrb374+/37PMv02KwgXNKZScQ8weiPlivWqt6RLStpz864cwSQvtdGYEbNHXKcY2+H3fnA9//NExO8WUpYwAMCGudXTmetpeun3fqv3I5G4xnqcZkMJ08oOeIv6SiMVICD4k+tirDd1+JZh3uePM7SJUtaT9yfSCIJFQx6DFmwhYKJtUCEPVhQpKz38i1Nklm9SRIFc//NExOgVmj4sAHiGuUkKFBg0zHfiTfFyVkxJhRxVeG4cEJCjog2oepu7BEI8+EQsPwOpkhLhLBn6BzyDLiwBH1U4h3Kf6MzUot9hrOrZ53DX8223vr2TnndFRSLilDI6//NExOQWItIsAHjGuT1ZzqpfYf8h/yVaQUKTxO529ckJVQ5C7bd1rcSriOOOHc3tkkOfmHz8k3rJSHtNMjJuEsPshdzVCIgxpwYCRcEpoVDFgxv/rzdc///7/7PFKe3X//NExN4a2rIsAMjGub7MOdu//zu1ys/XaW+B2TVCQrajR9JOARNA8wjf8jo5kKy9u6WOLfbn8cJUR917te7iAlgDcJUvmZijdVvLn5UfriNFNWc4p4j81klcqZa8qbOl//NExMUXAw40AMiGuZUr6EO6oa7A22M5rlLZWM+wZYOkxQa7jyR3LtDeYHKS5O/q/42Gux//1RPQbpwzMTlBo+xuuN1AI2EmEAggCTCTCTKhPMO6TUgxN50mNqXzUl/m//NExLwR6CpAAGCGAVDb2pNVsaowUSGARIVARtr9SE5IKjEHR4CKsHiIlKliS3fDQdUCChHI1ZQoKpyyuRkasFBAgaDkpWocsVoq/lX/slXDVREqRKIGrhqgxIrT2m36//NExMcSqgI8AGhEmQmmocsVoqWS01afTRV/3/9kq6VUVVNv///6VUxBTUUzLjEwMFVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVV//NExM8TYY44AHhGlFVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVV//NExNQSEHmgABjGSVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVV");




        echo '[
            {
              "notification_version": 2,
              "notification_data": [
                {
                  "notification_id": "1",
                  "notification_time": "12:21",
                  "notification_frequency": "DAILY",
                  "notification_title": "MORNING REMINDER",
                  "notification_content": "MORNING REMINDER CONTENT",
                  "notification_file": ' . $link1 . '
                
                },
                {
                  "notification_id": "2",
                  "notification_time": "12:23",
                  "notification_frequency": "DAILY",
                  "notification_title": "MORNING REMINDER",
                  "notification_content": "MORNING REMINDER CONTENT",
                  "notification_file": ' . $link2 . '                
                }
              ]
            }
          ]';
        break;

    case 'get-workplan-activity-types':

        // $x = [
        //     ["activity_code" => "HVST", "activity_desc" => "New House visits"],
        //     ["activity_code" => "FLWP", "activity_desc" => "Follow-up house visits"],
        //     ["activity_code" => "COMM", "activity_desc" => "Community meeting with AM / DM"],
        //     ["activity_code" => "HOSV", "activity_desc" => "Hospital visits with patients"]
        // ];


        getWorkplanTypes($conn, $_REQUEST);

        //echo json_encode($x);
        break;
    case 'get-app-version':
        echo json_encode(["version" => "1.51"]);
        break;
    case 'get-am-wise-sm-data':
        //   $conn = getConn1();

        $reqData["parent_type"] = "AM_WISE_SM";
        $reqData["parent"] =  $_REQUEST["user_id"];


        echo getCommonData1($conn, $reqData);
        break;
    case 'get-workplan-slot':
        //  $conn = getConn1();
        $_REQUEST["parent_type"] = "GET_WORKPLAN_SLOT";
        $_REQUEST["parent"] =  "";
        getCommonData1($conn, $_REQUEST);
        break;
    case 'get-workplan-data111111111111':
        getWorkPlanData($conn, $_REQUEST);
        break;
    case 'save-workplan11111111':
        saveWorkPlan($conn, $_REQUEST);

        //   echo json_encode(['status' => 1, 'message' => 'Saved Work Plan']);
        break;
    case 'getSurveyReportApp':

        getSurveyReportApp($conn, $_REQUEST);
        break;

    case 'get-identified-patients':
        getIdentPatients($conn, $_REQUEST);
        break;

    case 'get-followup-patient-detail':
        getFollowupPatientDetail($conn, $_REQUEST);
        break;
    case 'get-followup-outcome-list':
        getFollowupOutcomeList($conn, $_REQUEST);
        break;

    case 'get-followup-mode-list':

        getFollowupModeList($conn, $_REQUEST);
        // $data = [
        //     ["VAL_CD" => "1", "VAL_DESC" => "test"]
        // ];
        // echo json_encode($data);
        break;

    case 'save-followup':
        saveFollowup($conn, $_REQUEST);

        //echo json_encode(['status' => 1, 'message' => 'Testing']);
        break;

    case 'get-user-wise-statistics':


        // echo  json_encode($_REQUEST);
        //   exit;

        //   $_REQUEST["reqType"] = 'get-user-wise-statistics';


        // echo json_encode($_REQUEST);
        // exit;
        $query = "select 
                            * 
                    from 
                    sm_survey_call_logs s1 ,
                    (
                    select 
                            s.sscl_contact_no, 
                            max(s.sscl_call_date) max_call_date 
                    from sm_survey_call_logs s 
                    group by 
                        s.sscl_contact_no
                    ) s2
                    
                    where s2.sscl_contact_no = s1.sscl_contact_no
                    and s2.max_call_date = s1.sscl_call_date
                    ";



        $call_log = [];

        $stid = oci_parse($conn, $query);
        oci_execute($stid);



        while (($row = oci_fetch_assoc($stid)) != false) {
            $call_log[$row["SSCL_CONTACT_NO"]] = $row;
        }


        // echo json_encode($call_log);
        // exit;
        $curlHandle = curl_init("http://10.0.3.8/test/api_controller.php");
        curl_setopt($curlHandle, CURLOPT_POSTFIELDS, $_REQUEST);
        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);

        $curlResponse = curl_exec($curlHandle);
        $data = json_decode($curlResponse, true);
        $response = [];
        foreach ($data as $key => $value) {
            $response[$key] = $value;
            $response[$key]["CALL_LOG"] =  $call_log[$value['CONTACT']];
        }





        curl_close($curlHandle);
        echo json_encode($response);





        break;



    case 'get-last-call-logs':

        $i_user_id = $_REQUEST['user_id'];

        $query =
            "
                SELECT S1.sscl_contact_no    CONTACT_NO,
                S1.sscl_call_type     CALL_TYPE,
                to_char(S1.sscl_call_date, 'DD-MON-YYYY HH:MI AM')     CALL_DATE,
                decode(S1.SSCL_CALL_DURATION , 0, 'Not Connected' , trunc(S1.SSCL_CALL_DURATION/60) ||' Min '|| mod(S1.SSCL_CALL_DURATION, 60)|| ' Sec')  CALL_DURATION   
        FROM   sm_survey_call_logs s1,
                (SELECT s.sscl_contact_no,
                        Max(s.sscl_call_date) max_call_date
                FROM   sm_survey_call_logs s
                where s.sscl_caller_id = '$i_user_id'
                GROUP  BY s.sscl_contact_no) s2
        WHERE  s2.sscl_contact_no = s1.sscl_contact_no
                AND s2.max_call_date = s1.sscl_call_date 
                

        ";





        $stid = oci_parse($conn, $query);
        oci_execute($stid);

        $rows = [];
        while (($row = oci_fetch_assoc($stid)) != false) {
            $rows[] = $row;
        }

        echo json_encode($rows);



        break;



















    case 'save-call-log':
        saveSurveyCallLogs($conn, $_REQUEST);
        //echo json_encode(['status' => 1, 'message' => 'Testing']);
        break;


    case 'get-call-log':
        getSurveyCallLogs($conn, $_REQUEST);
        //echo json_encode(['status' => 1, 'message' => 'Testing']);
        break;

    case 'get-user-wise-statistics-report-types':

        $arr = array(
            [
                'VAL_CD' => "SM_WISE",
                'VAL_DESC' => "SM WISE"
            ],
            [
                'VAL_CD' => "AD_WISE",
                'VAL_DESC' => "ADE WISE"
            ],
            [
                'VAL_CD' => "BD_WISE",
                'VAL_DESC' => "BDE WISE"
            ],
            [
                'VAL_CD' => "ZM_WISE",
                'VAL_DESC' => "ZM WISE"
            ]
        );
        echo json_encode($arr);
        break;

    case 'get-call-logs-locations':

        $i_user_id = $_REQUEST['user_id'];

        if ($i_user_id = "7630") {

            echo json_encode(
                [
                    [
                        'VAL_CD' => "AS",
                        'VAL_DESC' => "ASSAM"
                    ],
                    [
                        'VAL_CD' => "WB",
                        'VAL_DESC' => "WEST BENGAL"
                    ]

                ]

            );
        } else {
            echo json_encode(
                [
                    [
                        'VAL_CD' => "AS",
                        'VAL_DESC' => "ASSAM"
                    ]

                ]

            );
        }

        break;
    case 'get-user-wise-op-ip-target-summ':
        $curlHandle = curl_init("http://10.0.3.8/swasthyamitra/api/1.0/index.php");
        curl_setopt($curlHandle, CURLOPT_POSTFIELDS, $_REQUEST);
        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
        $curlResponse = curl_exec($curlHandle);
        $data = json_decode($curlResponse, true);
        curl_close($curlHandle);
        echo json_encode($data);
        break;

    case 'get-user-wise-hsv-pid-target-summ':
        getHsvPidTargAchv($conn, $_REQUEST);
        break;
    case 'get-meeting-list':
        getMeetingList($conn,  $_REQUEST);
        break;
    case 'get-notification-list':
        getNotificationList($conn,  $_REQUEST);
        break;
    case 'update-notification-status':
        updateNotificationStatus($conn,  $_REQUEST);
        break;

    case 'get-unread-notification-count':

        getUnreadNotificationCount($conn,  $_REQUEST);
        break;

    case 'create-community-meeting':
        createCommunityMeeting($conn,  $_REQUEST);
        break;

    case 'add-community-meeting-participants':
        addCommunityMeetingParticipants($conn,  $_REQUEST);
        break;
    case 'upload-community-meeting-image':
        uploadCommunityMeetingImage($conn, $_REQUEST);
        break;
    case 'get-community-meeting-list':

        getCommunityMeetingList($conn, $_REQUEST);
        break;

    case 'get-community-meeting-participants':

        getCommunityParticipantList($conn, $_REQUEST);
        break;


    case 'complete-community-meeting':

        completeCommunityMeeting($conn, $_REQUEST);
        break;
    case 'remove-community-meeting-participant':

        removeCommunityMeetingParticipant($conn, $_REQUEST);
        break;

    case 'get-workplan-list-app':
        getWorkPlanListApp($conn, $_REQUEST);
        break;
    case 'update-workplan-list-app':
        updateWorkPlanListApp($conn, $_REQUEST);
        break;
    case 'get-workplan-assistant-list':
        getWorkplanAssistantList($conn, $_REQUEST);
        break;
    case 'get-user-wise-target-achievement-list':
        getUserWiseTargetAchievementList($conn, $_REQUEST);
        break;
    case 'get-community-meeting-close-remarks':
        getCommunityMeetingCloseRemarks($conn, $_REQUEST);
        break;
    case 'close-community-meeting':
        closeCommunityMeeting($conn, $_REQUEST);
        break;
    case 'get-workplan-slots':

        getWorkplanSlots($conn, $_REQUEST);
        break;
    case 'save-workplan-app':
        createWorkplanApp($conn, $_REQUEST);
        break;
    case 'delete-workplan':
        deleteWorkplan($conn, $_REQUEST);
        break;
    case 'get-emp-not-working-reasons':
        getEmpNotWorkingReasons($conn, $_REQUEST);
        break;
    default:
        # code...
        break;
}


function getWorkplanAssistantList($conn,  $reqData)
{

    $I_ORGANIZER_ID = $reqData['user_id'];
    $I_ORGANIZER_ROLE_CD = $reqData['user_role'];
    $I_ASSISTANT_ROLE_CD = $reqData['assistant_role'];

    $resultData = [];
    $curs = oci_new_cursor($conn);
    $query = "begin PKGPH_TEST_KKP.PRC_POPU_WRKPLN_ASSISTANT_LIST 
	(
        :I_ORGANIZER_ID,
        :I_ORGANIZER_ROLE_CD,
        :I_ASSISTANT_ROLE_CD,
        :O_CURS,
        :O_STATUS,
        :O_MESSAGE
        
	); 
	end;";
    $stid = oci_parse($conn, $query);
    if ($stid) {
        oci_bind_by_name($stid, ':I_ORGANIZER_ID', $I_ORGANIZER_ID, 100);
        oci_bind_by_name($stid, ':I_ORGANIZER_ROLE_CD', $I_ORGANIZER_ROLE_CD, 100);
        oci_bind_by_name($stid, ':I_ASSISTANT_ROLE_CD', $I_ASSISTANT_ROLE_CD, 100);
        oci_bind_by_name($stid, ":O_CURS", $curs, -1, OCI_B_CURSOR);
        oci_bind_by_name($stid, ":O_STATUS", $O_STATUS, 100);
        oci_bind_by_name($stid, ":O_MESSAGE", $O_MESSAGE, 100);
        $r = oci_execute($stid);
        if ($r) {
            $r1 = oci_execute($curs);
            if ($r1) {
                while (($r = oci_fetch_array($curs, OCI_ASSOC + OCI_RETURN_NULLS)) != false) {
                    $resultData[] =  $r;
                }
            } else {


                $e = oci_error($curs); // For oci_execute errors pass the statementhandle
                echo json_encode(["status" => 0, "message" => $e["message"]]);
            }
        } else {
            $e = oci_error($stid); // For oci_execute errors pass the statementhandle
            echo json_encode(["status" => 0, "message" => $e["message"]]);
            //  exit;
        }
    } else {
        $e = oci_error($conn);  // For oci_parse errors pass the connection handle
        echo htmlentities($e['message']);
    }
    echo json_encode($resultData);
    oci_free_statement($stid);
    oci_free_statement($curs);
    oci_close($conn);
}

function getWorkplanTypes($conn,  $reqData)
{

    $I_USER_ID = $reqData['user_id'];
    $I_USER_ROLE_CD = $reqData['user_role'];

    $resultData = [];
    $curs = oci_new_cursor($conn);
    $query = "begin PKGPH_TEST_KKP.PRC_POPU_WORKPLAN_TYPES 
	(
        :I_USER_ROLE_CD,
        :O_CURS,
        :O_STATUS,
        :O_MESSAGE
        
	); 
	end;";
    $stid = oci_parse($conn, $query);
    if ($stid) {
        oci_bind_by_name($stid, ':I_USER_ROLE_CD', $I_USER_ROLE_CD, 100);
        oci_bind_by_name($stid, ":O_CURS", $curs, -1, OCI_B_CURSOR);
        oci_bind_by_name($stid, ":O_STATUS", $O_STATUS, 100);
        oci_bind_by_name($stid, ":O_MESSAGE", $O_MESSAGE, 100);
        $r = oci_execute($stid);
        if ($r) {
            $r1 = oci_execute($curs);
            if ($r1) {
                while (($r = oci_fetch_array($curs, OCI_ASSOC + OCI_RETURN_NULLS)) != false) {
                    $resultData[] =  ["activity_code" => $r["SWPT_CD"], "activity_desc" => $r["SWPT_VAL"]];
                }
            } else {


                $e = oci_error($curs); // For oci_execute errors pass the statementhandle
                echo json_encode(["status" => 0, "message" => $e["message"]]);
            }
        } else {
            $e = oci_error($stid); // For oci_execute errors pass the statementhandle
            echo json_encode(["status" => 0, "message" => $e["message"]]);
            //  exit;
        }
    } else {
        $e = oci_error($conn);  // For oci_parse errors pass the connection handle
        echo htmlentities($e['message']);
    }
    echo json_encode($resultData);
    oci_free_statement($stid);
    oci_free_statement($curs);
    oci_close($conn);
}

function updateWorkPlanListApp($conn, $reqData)
{


    $I_PLAN_ID      =         $reqData['plan_id'];
    $I_PLAN_DT      =         $reqData['plan_dt'];
    $I_SLOT_CD      =         $reqData['slot_cd'];
    $I_ACTIVITY_CD  =         $reqData['activity_cd'];
    $I_ASSISTANT_ID =         $reqData['assistant_id'];
    $I_USER_ID      =         $reqData['user_id'];




    $query = "begin PKGPH_TEST_KKP.PRC_UPDT_WORKPLAN_APP
	(
        :I_PLAN_ID,
        :I_PLAN_DT,
        :I_SLOT_CD,
        :I_ACTIVITY_CD,
        :I_ASSISTANT_ID,
        :I_USER_ID,
        :O_STATUS,
        :O_MESSAGE
                                  
	); 
	end;";
    $stid = oci_parse($conn, $query);


    if (!$stid) {
        $e = oci_error($conn);  // For oci_parse errors pass the connection handle
        echo json_encode(['status' => "0", 'message' => "ERROR_PARSE"]);
        exit();
    }

    oci_bind_by_name($stid, ':I_PLAN_ID', $I_PLAN_ID, 100);
    oci_bind_by_name($stid, ':I_PLAN_DT', $I_PLAN_DT, 100);
    oci_bind_by_name($stid, ':I_SLOT_CD', $I_SLOT_CD, 100);
    oci_bind_by_name($stid, ':I_ACTIVITY_CD', $I_ACTIVITY_CD, 100);
    oci_bind_by_name($stid, ':I_ASSISTANT_ID', $I_ASSISTANT_ID, 100);
    oci_bind_by_name($stid, ':I_USER_ID', $I_USER_ID, 100);
    oci_bind_by_name($stid, ':O_STATUS', $O_STATUS, 100);
    oci_bind_by_name($stid, ':O_MESSAGE', $O_MESSAGE, 100);




    $r = oci_execute($stid, OCI_NO_AUTO_COMMIT);
    if (!$r) {
        $e = oci_error($stid); // For oci_execute errors pass the statementhandle
        echo json_encode(['status' => 0, 'message' => $e['message']]);
        exit();
    }

    if ($O_STATUS > 0) {
        $r = oci_commit($conn);
    } else {
        oci_rollback($conn);
    }
    echo json_encode(['status' => $O_STATUS, 'message' => $O_MESSAGE]);



    oci_free_statement($stid);
    oci_close($conn);
}

function uploadCommunityMeetingImage($conn, $reqData)
{


    $I_MEETING_ID = $reqData['meeting_id'];
    $I_IMAGE_PATH = $_FILES['image_path']['name'];
    $I_LOC_LAT = $reqData['addr_lat'];
    $I_LOC_LONG = $reqData['addr_long'];
    $resultData = [];
    $curs = oci_new_cursor($conn);
    $query = "begin PKGPH_TEST_KKP.PRC_UPLOAD_CMTY_MTNG_IMAGE 
	(
        :I_MEETING_ID
        ,:I_IMAGE_PATH
        ,:I_LOC_LAT
        ,:I_LOC_LONG
        ,:O_STATUS
        ,:O_MESSAGE
        
        
	); 
	end;";
    $stid = oci_parse($conn, $query);
    if ($stid) {
        oci_bind_by_name($stid, ':I_MEETING_ID', $I_MEETING_ID, 100);
        oci_bind_by_name($stid, ':I_IMAGE_PATH', $I_IMAGE_PATH, 1000);
        oci_bind_by_name($stid, ':I_LOC_LAT', $I_LOC_LAT, 100);
        oci_bind_by_name($stid, ':I_LOC_LONG', $I_LOC_LONG, 100);
        oci_bind_by_name($stid, ':O_STATUS', $O_STATUS, 100);
        oci_bind_by_name($stid, ':O_MESSAGE', $O_MESSAGE, 100);
        $r = oci_execute($stid, OCI_NO_AUTO_COMMIT);
        if ($r) {

            $folder = $_SERVER["DOCUMENT_ROOT"] . "/swasthyamitra/app/uploads/community_meetings/";
            if ($O_STATUS > 0) {
                $originalImgName = $_FILES['image_path']['name'];
                $tempName = $_FILES['image_path']['tmp_name'];
                $targetFile = $folder . $originalImgName;
                if (file_exists($targetFile)) {
                    unlink($targetFile);
                }
                //sleep for 3 seconds
                sleep(5);
                if (move_uploaded_file($tempName, $targetFile)) {

                    fixImageOrientation($targetFile);
                    oci_commit($conn);
                } else {
                    //unlink($folder ."/". $originalImgName);
                    oci_rollback($conn);
                    $O_STATUS = 0;
                    $O_MESSAGE = "Failed to Upload Community Image" . json_encode($_FILES);
                }
            }

            echo json_encode(["status" => $O_STATUS, "message" => $O_MESSAGE]);
        } else {
            $e = oci_error($stid); // For oci_execute errors pass the statementhandle
            echo json_encode(["status" => 0, "message" => $e["message"]]);
            //  exit;
        }
    } else {
        $e = oci_error($conn);  // For oci_parse errors pass the connection handle
        echo htmlentities($e['message']);
        echo json_encode(["status" => 0, "message" => $e['message']]);
    }
    echo json_encode($resultData);
    oci_free_statement($stid);
    oci_free_statement($curs);
    oci_close($conn);
}

function fixImageOrientation($filename)
{
    $exif = exif_read_data($filename);

    if ($exif && isset($exif['Orientation'])) {
        $orientation = $exif['Orientation'];

        if ($orientation != 1) {
            $image = imagecreatefromjpeg($filename);

            switch ($orientation) {
                case 3:
                    $image = imagerotate($image, 180, 0);
                    break;

                case 6:
                    $image = imagerotate($image, -90, 0);
                    break;

                case 8:
                    $image = imagerotate($image, 90, 0);
                    break;
            }

            imagejpeg($image, $filename);
        }
    }
}

function removeCommunityMeetingParticipant($conn, $reqData)
{

    $I_CMTY_MEETING_ID = $reqData['meeting_id'];
    $I_CMTY_MEETING_PRTCPNT_ID = $reqData['participant_id'];



    $query = "begin PKGPH_TEST_KKP.PRC_DELT_COMTY_MTNG_PARTCPNT 
	(
         :I_CMTY_MEETING_ID
        ,:I_CMTY_MEETING_PRTCPNT_ID
        ,:O_STATUS
        ,:O_MESSAGE
        
        
	); 
	end;";
    $stid = oci_parse($conn, $query);
    if ($stid) {
        oci_bind_by_name($stid, ':I_CMTY_MEETING_ID', $I_CMTY_MEETING_ID, 100);
        oci_bind_by_name($stid, ':I_CMTY_MEETING_PRTCPNT_ID', $I_CMTY_MEETING_PRTCPNT_ID, 100);
        oci_bind_by_name($stid, ':O_STATUS', $O_STATUS, 100);
        oci_bind_by_name($stid, ':O_MESSAGE', $O_MESSAGE, 100);
        $r = oci_execute($stid, OCI_NO_AUTO_COMMIT);
        if ($r) {
            echo json_encode(["status" => $O_STATUS, "message" => $O_MESSAGE]);
        } else {
            $e = oci_error($stid); // For oci_execute errors pass the statementhandle
            echo json_encode(["status" => 0, "message" => $e["message"]]);
            //  exit;
        }
    } else {
        $e = oci_error($conn);  // For oci_parse errors pass the connection handle
        echo htmlentities($e['message']);
        echo json_encode(["status" => 0, "message" => $e['message']]);
    }


    if ($O_STATUS > 0) {
        oci_commit($conn);
    } else {
        oci_rollback($conn);
    }
    oci_free_statement($stid);
    oci_close($conn);
}

function getCommunityParticipantList($conn,  $reqData)
{
    $I_CMTY_MEETING_ID = $reqData['meeting_id'];

    $resultData = [];
    $curs = oci_new_cursor($conn);
    $query = "begin PKGPH_TEST_KKP.PRC_POPU_COMTY_MTNG_PRTICIPNTS 
	(
        :I_CMTY_MEETING_ID,
        :O_CURS,
        :O_STATUS,
        :O_MESSAGE
        
	); 
	end;";
    $stid = oci_parse($conn, $query);
    if ($stid) {
        oci_bind_by_name($stid, ':I_CMTY_MEETING_ID', $I_CMTY_MEETING_ID, 100);
        oci_bind_by_name($stid, ":O_CURS", $curs, -1, OCI_B_CURSOR);
        oci_bind_by_name($stid, ":O_STATUS", $O_STATUS, 100);
        oci_bind_by_name($stid, ":O_MESSAGE", $O_MESSAGE, 100);
        $r = oci_execute($stid);
        if ($r) {
            $r1 = oci_execute($curs);
            if ($r1) {

                while (($r = oci_fetch_array($curs, OCI_ASSOC + OCI_RETURN_NULLS)) != false) {
                    $resultData[] = $r;
                }
            } else {


                $e = oci_error($curs); // For oci_execute errors pass the statementhandle
                echo json_encode(["status" => 0, "message" => $e["message"]]);
            }
        } else {
            $e = oci_error($stid); // For oci_execute errors pass the statementhandle
            echo json_encode(["status" => 0, "message" => $e["message"]]);
            //  exit;
        }
    } else {
        $e = oci_error($conn);  // For oci_parse errors pass the connection handle
        echo htmlentities($e['message']);
    }
    echo json_encode($resultData);
    oci_free_statement($stid);
    oci_free_statement($curs);
    oci_close($conn);
}

function getCommunityMeetingList($conn,  $reqData)
{
    $I_USER_ROLE = $reqData['user_role'];
    $I_USER_ID = $reqData['user_id'];
    $I_PLAN_ID = "zzzzzzzzz";
    $resultData = [];
    $curs = oci_new_cursor($conn);
    $query = "begin PKGPH_TEST_KKP.PRC_POPU_COMTY_MTNG_LIST 
	(
        :I_USER_ID,   
        :I_USER_ROLE,   
        :I_PLAN_ID,   
        :O_CURS,
        :O_STATUS,
        :O_MESSAGE
	); 
	end;";
    $stid = oci_parse($conn, $query);
    if ($stid) {
        oci_bind_by_name($stid, ':I_USER_ID', $I_USER_ID, 100);
        oci_bind_by_name($stid, ':I_USER_ROLE', $I_USER_ROLE, 100);
        oci_bind_by_name($stid, ':I_PLAN_ID', $I_PLAN_ID, 100);
        oci_bind_by_name($stid, ":O_CURS", $curs, -1, OCI_B_CURSOR);
        oci_bind_by_name($stid, ":O_STATUS", $O_STATUS, 100);
        oci_bind_by_name($stid, ":O_MESSAGE", $O_MESSAGE, 100);
        $r = oci_execute($stid);
        if ($r) {
            $r1 = oci_execute($curs);
            if ($r1) {

                while (($r = oci_fetch_array($curs, OCI_ASSOC + OCI_RETURN_NULLS)) != false) {
                    $resultData[] = [
                        "meeting_id" => $r["SCMH_ID"],
                        "meeting_topic" => $r["SCMH_TOPIC"],
                        "meeting_date_time" => $r["SCMH_DATE_TIME"],
                        "meeting_address" => $r["SCMH_ADDRESS"],
                        "meeting_image_path" => $r["IMAGE_PATH"],
                        "meeting_slot_time" => $r["SLOT_NAME"],
                        "meeting_status" => $r["STATUS"]




                    ];
                }
            } else {


                $e = oci_error($curs); // For oci_execute errors pass the statementhandle
                echo json_encode(["status" => 0, "message" => $e["message"]]);
            }
        } else {
            $e = oci_error($stid); // For oci_execute errors pass the statementhandle
            echo json_encode(["status" => 0, "message" => $e["message"]]);
            //  exit;
        }
    } else {
        $e = oci_error($conn);  // For oci_parse errors pass the connection handle
        echo htmlentities($e['message']);
    }
    echo json_encode($resultData);
    oci_free_statement($stid);
    oci_free_statement($curs);
    oci_close($conn);
}

function completeCommunityMeeting($conn, $reqData)
{


    $I_CMTY_MEETING_ID = $reqData['meeting_id'];
    $I_USER_ID = $reqData['user_id'];

    $query = "begin PKGPH_TEST_KKP.PRC_COMPLETE_COMTY_MTNG
	(
        :I_CMTY_MEETING_ID,
        :I_USER_ID,
        :O_STATUS,
        :O_MESSAGE
                                     
	); 
	end;";
    $stid = oci_parse($conn, $query);


    if (!$stid) {
        $e = oci_error($conn);  // For oci_parse errors pass the connection handle
        echo json_encode(['status' => "0", 'message' => "ERROR_PARSE"]);
        exit();
    }

    oci_bind_by_name($stid, ':I_CMTY_MEETING_ID', $I_CMTY_MEETING_ID, 100);
    oci_bind_by_name($stid, ':I_USER_ID', $I_USER_ID, 100);
    oci_bind_by_name($stid, ':O_STATUS', $O_STATUS, 100);
    oci_bind_by_name($stid, ':O_MESSAGE', $O_MESSAGE, 100);
    oci_bind_by_name($stid, ':O_STATUS', $O_STATUS, 100);




    $r = oci_execute($stid, OCI_NO_AUTO_COMMIT);
    if (!$r) {
        $e = oci_error($stid); // For oci_execute errors pass the statementhandle
        echo json_encode(['status' => 0, 'message' => $e['message']]);
        exit();
    }

    if ($O_STATUS > 0) {
        $r = oci_commit($conn);
    } else {
        oci_rollback($conn);
    }
    echo json_encode(['status' => $O_STATUS, 'message' => $O_MESSAGE]);



    oci_free_statement($stid);
    oci_close($conn);
}

function createCommunityMeeting($conn, $reqData)
{


    $I_TOPIC = $reqData['topic'];
    $I_DATE_TIME = $reqData['date_time'];
    $I_ADDRESS = $reqData['address'];
    $I_COORDINATES_LAT = $reqData['coordinates_lat'];
    $I_COORDINATES_LONG = $reqData['coordinates_long'];
    $I_REFERENCE_NO = $reqData['reference_no'];
    $I_USER_ROLE = $reqData['user_role'];
    $I_USER_ID = $reqData['user_id'];
    $I_USER_STATE_CD = $reqData['user_state_cd'];
    $I_REMARKS = $reqData['remarks'];

    $query = "begin PKGPH_TEST_KKP.PRC_CREATE_COMMUNITY_MEETING
	(
        :I_TOPIC                                
        ,:I_DATE_TIME                            
        ,:I_ADDRESS                              
        ,:I_COORDINATES_LAT                      
        ,:I_COORDINATES_LONG                     
        ,:I_REFERENCE_NO                         
        ,:I_USER_ROLE                            
        ,:I_USER_ID                              
        ,:I_USER_STATE_CD                        
        ,:I_REMARKS                              
        ,:O_STATUS                               
        ,:O_MESSAGE                              
	); 
	end;";
    $stid = oci_parse($conn, $query);


    if (!$stid) {
        $e = oci_error($conn);  // For oci_parse errors pass the connection handle
        echo json_encode(['status' => "0", 'message' => "ERROR_PARSE"]);
        exit();
    }

    oci_bind_by_name($stid, ':I_TOPIC', $I_TOPIC, 1000);
    oci_bind_by_name($stid, ':I_DATE_TIME', $I_DATE_TIME, 1000);
    oci_bind_by_name($stid, ':I_ADDRESS', $I_ADDRESS, 1000);
    oci_bind_by_name($stid, ':I_COORDINATES_LAT', $I_COORDINATES_LAT, 1000);
    oci_bind_by_name($stid, ':I_COORDINATES_LONG', $I_COORDINATES_LONG, 1000);
    oci_bind_by_name($stid, ':I_REFERENCE_NO', $I_REFERENCE_NO, 1000);
    oci_bind_by_name($stid, ':I_USER_ROLE', $I_USER_ROLE, 1000);
    oci_bind_by_name($stid, ':I_USER_ID', $I_USER_ID, 1000);
    oci_bind_by_name($stid, ':I_USER_STATE_CD', $I_USER_STATE_CD, 1000);
    oci_bind_by_name($stid, ':I_REMARKS', $I_REMARKS, 1000);
    oci_bind_by_name($stid, ':O_STATUS', $O_STATUS, 1000);
    oci_bind_by_name($stid, ':O_MESSAGE', $O_MESSAGE, 1000);



    $r = oci_execute($stid, OCI_NO_AUTO_COMMIT);
    if (!$r) {
        $e = oci_error($stid); // For oci_execute errors pass the statementhandle
        echo json_encode(['status' => 0, 'message' => $e['message']]);
        exit();
    }

    if ($O_STATUS > 0) {
        $r = oci_commit($conn);
    } else {
        oci_rollback($conn);
    }
    echo json_encode(['status' => $O_STATUS, 'message' => $O_MESSAGE]);



    oci_free_statement($stid);
    oci_close($conn);
}

function addCommunityMeetingParticipants($conn, $reqData)
{



    $I_MEETING_ID = $reqData['meeting_id'];
    $I_PARTICIPANT_NAME = $reqData['participant_name'];
    $I_PARTICIPANT_AGE = $reqData['participant_age'];
    $I_PARTICIPANT_GENDER = $reqData['participant_gender'];
    $I_PARTICIPANT_CONTACT_NO = $reqData['participant_contact_no'];
    $I_PARTICIPANT_SYMPTOMATIC = $reqData['participant_symptomatic'];
    $I_PARTICIPANT_BP_SYS = $reqData['participant_bp_sys'];
    $I_PARTICIPANT_BP_DIA = $reqData['participant_bp_dia'];
    $I_PARTICIPANT_SUGAR_TYP = $reqData['participant_sugar_type'];
    $I_PARTICIPANT_SUGAR_VAL = $reqData['participant_sugar_value'];
    $I_MAGAZINE_AVAILED = $reqData['magazine_availed'];
    $I_USER_ID = $reqData['user_id'];


    // echo json_encode($reqData);



    $query = "begin PKGPH_TEST_KKP.PRC_ADD_CMTY_MTNG_PARTICIPANT
	(
         :I_MEETING_ID                                
        ,:I_PARTICIPANT_NAME                            
        ,:I_PARTICIPANT_AGE                              
        ,:I_PARTICIPANT_GENDER                      
        ,:I_PARTICIPANT_CONTACT_NO                     
        ,:I_PARTICIPANT_SYMPTOMATIC
        ,:I_PARTICIPANT_BP_SYS                            
        ,:I_PARTICIPANT_BP_DIA                            
        ,:I_PARTICIPANT_SUGAR_TYP                         
        ,:I_PARTICIPANT_SUGAR_VAL                         
        ,:I_MAGAZINE_AVAILED 
        ,:I_USER_ID                        
        ,:O_STATUS                               
        ,:O_MESSAGE                              
	); 
	end;";
    $stid = oci_parse($conn, $query);


    if (!$stid) {
        $e = oci_error($conn);  // For oci_parse errors pass the connection handle
        echo json_encode(['status' => "0", 'message' => "ERROR_PARSE"]);
        exit();
    }

    oci_bind_by_name($stid, ':I_MEETING_ID', $I_MEETING_ID, 1000);
    oci_bind_by_name($stid, ':I_PARTICIPANT_NAME', $I_PARTICIPANT_NAME, 1000);
    oci_bind_by_name($stid, ':I_PARTICIPANT_AGE', $I_PARTICIPANT_AGE, 1000);
    oci_bind_by_name($stid, ':I_PARTICIPANT_GENDER', $I_PARTICIPANT_GENDER, 1000);
    oci_bind_by_name($stid, ':I_PARTICIPANT_CONTACT_NO', $I_PARTICIPANT_CONTACT_NO, 1000);
    oci_bind_by_name($stid, ':I_PARTICIPANT_SYMPTOMATIC', $I_PARTICIPANT_SYMPTOMATIC, 1000);
    oci_bind_by_name($stid, ':I_PARTICIPANT_BP_SYS', $I_PARTICIPANT_BP_SYS, 1000);
    oci_bind_by_name($stid, ':I_PARTICIPANT_BP_DIA', $I_PARTICIPANT_BP_DIA, 1000);
    oci_bind_by_name($stid, ':I_PARTICIPANT_SUGAR_TYP', $I_PARTICIPANT_SUGAR_TYP, 1000);
    oci_bind_by_name($stid, ':I_PARTICIPANT_SUGAR_VAL', $I_PARTICIPANT_SUGAR_VAL, 1000);
    oci_bind_by_name($stid, ':I_MAGAZINE_AVAILED', $I_MAGAZINE_AVAILED, 1000);
    oci_bind_by_name($stid, ':I_USER_ID', $I_USER_ID, 1000);
    oci_bind_by_name($stid, ':O_STATUS', $O_STATUS, 1000);
    oci_bind_by_name($stid, ':O_MESSAGE', $O_MESSAGE, 1000);



    $r = oci_execute($stid, OCI_NO_AUTO_COMMIT);
    if (!$r) {
        $e = oci_error($stid); // For oci_execute errors pass the statementhandle
        echo json_encode(['status' => 0, 'message' => $e['message']]);
        exit();
    }

    if ($O_STATUS > 0) {
        $r = oci_commit($conn);
    } else {
        oci_rollback($conn);
    }
    echo json_encode(['status' => $O_STATUS, 'message' => $O_MESSAGE]);



    oci_free_statement($stid);
    oci_close($conn);
}

function getMeetingList($conn,  $reqData)
{



    $I_REQ_TYPE = $reqData['user_role'];
    $I_REQ_FOR = $reqData['user_id'];
    $resultData = [];
    $curs = oci_new_cursor($conn);
    $query = "begin PKGPH_SM_MEETING.PRC_POPU_MEETING_LIST 
	(
        :I_REQ_TYPE,   
        :I_REQ_FOR,   
        :O_CURS,
        :O_Msg,
        :O_ErrMsg
	); 
	end;";
    $stid = oci_parse($conn, $query);
    if ($stid) {
        oci_bind_by_name($stid, ':I_REQ_TYPE', $I_REQ_TYPE, 100);
        oci_bind_by_name($stid, ':I_REQ_FOR', $I_REQ_FOR, 100);
        oci_bind_by_name($stid, ":O_CURS", $curs, -1, OCI_B_CURSOR);
        oci_bind_by_name($stid, ":O_Msg", $O_Msg, 100);
        oci_bind_by_name($stid, ":O_ErrMsg", $O_ErrMsg, 100);
        $r = oci_execute($stid);
        if ($r) {


            $r1 = oci_execute($curs);
            if ($r1) {

                while (($r = oci_fetch_array($curs, OCI_ASSOC + OCI_RETURN_NULLS)) != false) {



                    $resultData[] = [
                        "meeting_start_time" => date("d-m-Y h:i:s a", strtotime($r['MTNG_DT_TM'])),
                        "meeting_join_time" => date("d-m-Y h:i:s a", strtotime($r['JOIN_DT_TM'])),
                        "meeting_title" => $r['MTNG_TITLE'],
                        "meeting_desc" => $r['MTNG_DETAIL'],
                        "zoom_link" => $r['URL']
                    ];


                    // $arr = [
                    //     [
                    //         "meeting_date" => "10-June-2023",
                    //         "meeting_time" => "10:00 am",
                    //         "meeting_topic" => "Meeting with CMD",
                    //         "zoom_link" => 'https://us05web.zoom.us/j/87908537396?pwd=hTwaYDY9b0POarUURL7KHGVmIQFOaK.1&uname=krishna'
                    //     ],

                    //     [
                    //         "meeting_date" => "11-June-2023",
                    //         "meeting_time" => "10:00 am",
                    //         "meeting_topic" => "Meeting with Zonal Managers",
                    //         "zoom_link" => 'https://us05web.zoom.us/j/87908537396?pwd=hTwaYDY9b0POarUURL7KHGVmIQFOaK.1&uname=krishna'
                    //     ]
                    // ];
                    // echo json_encode($arr);



                }
            } else {


                $e = oci_error($curs); // For oci_execute errors pass the statementhandle
                echo json_encode(["status" => 0, "message" => $e["message"]]);
            }
        } else {
            $e = oci_error($stid); // For oci_execute errors pass the statementhandle
            echo json_encode(["status" => 0, "message" => $e["message"]]);
            //  exit;
        }
    } else {
        $e = oci_error($conn);  // For oci_parse errors pass the connection handle
        echo htmlentities($e['message']);
    }
    echo json_encode($resultData);
    oci_free_statement($stid);
    oci_free_statement($curs);
    oci_close($conn);
}

function getNotificationList($conn,  $reqData)
{



    $I_REQ_TYPE = $reqData['user_role'];
    $I_REQ_FOR = $reqData['user_id'];
    $resultData = [];
    $curs = oci_new_cursor($conn);
    $query = "begin PKGPH_SM_NOTIFICATION.PRC_POPU_NOTIFICATION 
	(
        :I_REQ_TYPE,   
        :I_REQ_FOR,   
        :O_CURS,
        :O_Msg,
        :O_ErrMsg
	); 
	end;";
    $stid = oci_parse($conn, $query);
    if ($stid) {
        oci_bind_by_name($stid, ':I_REQ_TYPE', $I_REQ_TYPE, 100);
        oci_bind_by_name($stid, ':I_REQ_FOR', $I_REQ_FOR, 100);
        oci_bind_by_name($stid, ":O_CURS", $curs, -1, OCI_B_CURSOR);
        oci_bind_by_name($stid, ":O_Msg", $O_Msg, 100);
        oci_bind_by_name($stid, ":O_ErrMsg", $O_ErrMsg, 100);
        $r = oci_execute($stid);
        if ($r) {


            $r1 = oci_execute($curs);
            if ($r1) {

                while (($r = oci_fetch_array($curs, OCI_ASSOC + OCI_RETURN_NULLS)) != false) {



                    $resultData[$r["NOTI_TIME"]][] = $r;


                    // $arr = [
                    //     [
                    //         "meeting_date" => "10-June-2023",
                    //         "meeting_time" => "10:00 am",
                    //         "meeting_topic" => "Meeting with CMD",
                    //         "zoom_link" => 'https://us05web.zoom.us/j/87908537396?pwd=hTwaYDY9b0POarUURL7KHGVmIQFOaK.1&uname=krishna'
                    //     ],

                    //     [
                    //         "meeting_date" => "11-June-2023",
                    //         "meeting_time" => "10:00 am",
                    //         "meeting_topic" => "Meeting with Zonal Managers",
                    //         "zoom_link" => 'https://us05web.zoom.us/j/87908537396?pwd=hTwaYDY9b0POarUURL7KHGVmIQFOaK.1&uname=krishna'
                    //     ]
                    // ];
                    // echo json_encode($arr);



                }
            } else {


                $e = oci_error($curs); // For oci_execute errors pass the statementhandle
                echo json_encode(["status" => 0, "message" => $e["message"]]);
            }
        } else {
            $e = oci_error($stid); // For oci_execute errors pass the statementhandle
            echo json_encode(["status" => 0, "message" => $e["message"]]);
            //  exit;
        }
    } else {
        $e = oci_error($conn);  // For oci_parse errors pass the connection handle
        echo htmlentities($e['message']);
    }
    echo json_encode($resultData);
    oci_free_statement($stid);
    oci_free_statement($curs);
    oci_close($conn);
}

function updateNotificationStatus($conn, $reqData)
{

    $i_NOTI_ID = $reqData['notification_id'];
    $query = "begin PKGPH_SM_NOTIFICATION.PRC_R_NOTIFICATION
	(
         :i_NOTI_ID                
        ,:o_Msg              
        ,:o_RetMsg                    
	); 
	end;";
    $stid = oci_parse($conn, $query);


    if (!$stid) {
        $e = oci_error($conn);  // For oci_parse errors pass the connection handle
        echo json_encode(['status' => "0", 'message' => "ERROR_PARSE"]);
        exit();
    }


    oci_bind_by_name($stid, ':i_NOTI_ID', $i_NOTI_ID, 100);
    oci_bind_by_name($stid, ':o_Msg', $o_Msg, 100);
    oci_bind_by_name($stid, ':o_RetMsg', $o_RetMsg, 100);



    $r = oci_execute($stid, OCI_NO_AUTO_COMMIT);
    if (!$r) {
        $e = oci_error($stid); // For oci_execute errors pass the statementhandle
        echo json_encode(['status' => 0, 'message' => $e['message']]);
        exit();
    }

    if ($o_Msg > 0) {
        $r = oci_commit($conn);
        echo json_encode(['status' => 1111111, 'message' => $o_RetMsg]);
    } else {
        oci_rollback($conn);
        echo json_encode(['status' => 0, 'message' => $o_RetMsg . "sssss"]);
    }

    oci_free_statement($stid);
    oci_close($conn);
}

function getUnreadNotificationCount($conn,  $reqData)
{



    $i_USER_ID = $reqData['user_id'];
    $resultData = [];
    $curs = oci_new_cursor($conn);
    $query = "begin PKGPH_SM_NOTIFICATION.PRC_C_UNREAD_NOTI 
	(
        :i_USER_ID,   
        :o_Count
	); 
	end;";
    $stid = oci_parse($conn, $query);
    if ($stid) {
        oci_bind_by_name($stid, ':i_USER_ID', $i_USER_ID, 100);
        oci_bind_by_name($stid, ':o_Count', $o_Count, 100);
        $r = oci_execute($stid);
        if ($r) {
            echo json_encode(["status" => 1, "count" => $o_Count]);
        } else {
            $e = oci_error($stid); // For oci_execute errors pass the statementhandle
            echo json_encode(["status" => 0, "count" => 0, "message" => $e["message"]]);
            //  exit;
        }
    } else {
        $e = oci_error($conn);  // For oci_parse errors pass the connection handle
        echo htmlentities($e['message']);
    }

    oci_free_statement($stid);
    oci_free_statement($curs);
    oci_close($conn);
}

function getWorkPlanListApp($conn,  $reqData)
{



    $I_RPT_TYPE = $reqData['rpt_type'];
    $I_USER_ID = $reqData['user_id'];
    $I_USER_ROLE_CD = $reqData['user_role'];
    $resultData = [];
    $curs = oci_new_cursor($conn);
    $query = "begin PKGPH_TEST_KKP.PRC_POPU_WORKPLAN_APP 
	(
        :I_RPT_TYPE,   
        :I_USER_ID,   
        :I_USER_ROLE_CD,   
        :O_CURS,
        :O_STATUS,
        :O_MESSAGE
	); 
	end;";
    $stid = oci_parse($conn, $query);
    if ($stid) {
        oci_bind_by_name($stid, ':I_RPT_TYPE', $I_RPT_TYPE, 100);
        oci_bind_by_name($stid, ':I_USER_ID', $I_USER_ID, 100);
        oci_bind_by_name($stid, ':I_USER_ROLE_CD', $I_USER_ROLE_CD, 100);
        oci_bind_by_name($stid, ":O_CURS", $curs, -1, OCI_B_CURSOR);
        oci_bind_by_name($stid, ":O_STATUS", $O_STATUS, 100);
        oci_bind_by_name($stid, ":O_MESSAGE", $O_MESSAGE, 100);
        $r = oci_execute($stid);
        if ($r) {


            $r1 = oci_execute($curs);
            if ($r1) {

                while (($r = oci_fetch_array($curs, OCI_ASSOC + OCI_RETURN_NULLS)) != false) {
                    $resultData[$r['PLAN_DATE']][] = $r;
                }
            } else {
                $e = oci_error($curs); // For oci_execute errors pass the statementhandle
                echo json_encode(["status" => 0, "message" => $e["message"]]);
            }
        } else {
            $e = oci_error($stid); // For oci_execute errors pass the statementhandle
            echo json_encode(["status" => 0, "message" => $e["message"]]);
            //  exit;
        }
    } else {
        $e = oci_error($conn);  // For oci_parse errors pass the connection handle
        echo htmlentities($e['message']);
    }
    echo json_encode($resultData);
    oci_free_statement($stid);
    oci_free_statement($curs);
    oci_close($conn);
}


function validateUserSession($conn, $reqData)
{


    
    $I_USER_ID = $reqData['user_id'];
    $I_TOKEN = $reqData['auth_token'];

    $query = "begin PKGPH_TEST_KKP.PRC_VALIDATE_USER_TOKEN
	(
         :I_USER_ID                
        ,:I_TOKEN                        
        ,:O_ACTIVE_STATUS              
        ,:O_STATUS                 
        ,:O_MESSAGE                
	); 
	end;";
    $stid = oci_parse($conn, $query);


    if (!$stid) {
        $e = oci_error($conn);  // For oci_parse errors pass the connection handle
        echo json_encode(['status' => "0", 'message' => $e["message"], 'active_status' => 1]);
        exit();
    }


    oci_bind_by_name($stid, ':I_USER_ID', $I_USER_ID, 100);
    oci_bind_by_name($stid, ':I_TOKEN', $I_TOKEN, 100);
    oci_bind_by_name($stid, ':O_ACTIVE_STATUS', $O_ACTIVE_STATUS, 100);
    oci_bind_by_name($stid, ':O_STATUS', $O_STATUS, 100);
    oci_bind_by_name($stid, ':O_MESSAGE', $O_MESSAGE, 100);
    $r = oci_execute($stid);
    if (!$r) {
        $e = oci_error($stid); // For oci_execute errors pass the statementhandle
        echo json_encode(['status' => "0", 'message' =>  $e['message'], 'active_status' => 1]);
        exit();
    }
    echo json_encode(['status' => $O_STATUS, 'message' => $O_MESSAGE, 'active_status' => $O_ACTIVE_STATUS]);


    oci_free_statement($stid);
    oci_close($conn);
}
















function getFollowupModeList($conn,  $reqData)
{

    // ECHO json_encode(["status" => 1, "message" => 'Testing']);
    $resultData = [];
    $I_INPUT_TYPE = "FM";




    $curs = oci_new_cursor($conn);
    $query = "begin PKG_Work_Plan_DP.PRC_POPU_PARAM 
	(
        :I_INPUT_TYPE,   
        :O_CUR_FUP,
        :O_Msg,
        :O_ErrMsg
	); 
	end;";
    $stid = oci_parse($conn, $query);
    $data = "";
    if ($stid) {
        oci_bind_by_name($stid, ':I_INPUT_TYPE', $I_INPUT_TYPE, 100);
        oci_bind_by_name($stid, ":O_CUR_FUP", $curs, -1, OCI_B_CURSOR);
        oci_bind_by_name($stid, ":O_Msg", $O_Msg, 100);
        oci_bind_by_name($stid, ":O_ErrMsg", $O_ErrMsg, 100);
        $r = oci_execute($stid);
        if ($r) {
            $r1 = oci_execute($curs);
            if ($r1) {
                while (($r = oci_fetch_array($curs, OCI_ASSOC + OCI_RETURN_NULLS)) != false) {
                    $resultData[] = $r;
                }
                echo json_encode($resultData);
            } else {
                $e = oci_error($curs); // For oci_execute errors pass the statementhandle
                echo json_encode(["status" => 0, "message" => $e["message"]]);
            }
        } else {
            $e = oci_error($stid); // For oci_execute errors pass the statementhandle
            echo json_encode(["status" => 0, "message" => $e["message"]]);
            //  exit;
        }
    } else {
        $e = oci_error($conn);  // For oci_parse errors pass the connection handle
        echo htmlentities($e['message']);
    }

    oci_free_statement($stid);
    oci_free_statement($curs);
    oci_close($conn);
}

function getFollowupOutcomeList($conn,  $reqData)
{

    // ECHO json_encode(["status" => 1, "message" => 'Testing']);
    $resultData = [];
    $I_INPUT_TYPE = "FUP";




    $curs = oci_new_cursor($conn);
    $query = "begin PKG_Work_Plan_DP.PRC_POPU_PARAM 
	(
        :I_INPUT_TYPE,   
        :O_CUR_FUP,
        :O_Msg,
        :O_ErrMsg
	); 
	end;";
    $stid = oci_parse($conn, $query);
    $data = "";
    if ($stid) {
        oci_bind_by_name($stid, ':I_INPUT_TYPE', $I_INPUT_TYPE, 100);
        oci_bind_by_name($stid, ":O_CUR_FUP", $curs, -1, OCI_B_CURSOR);
        oci_bind_by_name($stid, ":O_Msg", $O_Msg, 100);
        oci_bind_by_name($stid, ":O_ErrMsg", $O_ErrMsg, 100);
        $r = oci_execute($stid);
        if ($r) {
            $r1 = oci_execute($curs);
            if ($r1) {
                while (($r = oci_fetch_array($curs, OCI_ASSOC + OCI_RETURN_NULLS)) != false) {
                    $resultData[] = $r;
                }
                echo json_encode($resultData);
            } else {
                $e = oci_error($curs); // For oci_execute errors pass the statementhandle
                echo json_encode(["status" => 0, "message" => $e["message"]]);
            }
        } else {
            $e = oci_error($stid); // For oci_execute errors pass the statementhandle
            echo json_encode(["status" => 0, "message" => $e["message"]]);
            //  exit;
        }
    } else {
        $e = oci_error($conn);  // For oci_parse errors pass the connection handle
        echo htmlentities($e['message']);
    }

    oci_free_statement($stid);
    oci_free_statement($curs);
    oci_close($conn);
}

function getSurveyReportApp($conn, $reqData)
{


    $resultData = [];
    $I_START_DT = date("d-m-Y", strtotime($reqData["fromDate"]));
    $I_END_DT =  date("d-m-Y", strtotime($reqData["toDate"]));
    $I_USER_CD =  date("d-m-Y", strtotime($reqData["userId"]));
    $I_USER_ROLE =  date("d-m-Y", strtotime($reqData["userRole"]));





    $curs = oci_new_cursor($conn);
    $query = "begin PKGPH_SM_SURVEY_2021.PRC_POPU_SURVEY_RPT_APP 
	(
        :I_START_DT,   
        :I_END_DT,
        :I_USER_CD,
        :I_USER_ROLE,
        :cS_Data
	); 
	end;";
    $stid = oci_parse($conn, $query);
    $data = "";
    if ($stid) {
        oci_bind_by_name($stid, ':I_START_DT', $I_START_DT, 100);
        oci_bind_by_name($stid, ':I_END_DT', $I_END_DT, 100);
        oci_bind_by_name($stid, ':I_USER_CD', $I_USER_CD, 100);
        oci_bind_by_name($stid, ':I_USER_ROLE', $I_USER_ROLE, 100);
        oci_bind_by_name($stid, ":cS_Data", $curs, -1, OCI_B_CURSOR);
        $r = oci_execute($stid);
        if ($r) {
            $r1 = oci_execute($curs);
            if ($r1) {
                while (($r = oci_fetch_array($curs, OCI_ASSOC + OCI_RETURN_NULLS)) != false) {
                    $resultData[] = [
                        "surveyDate" => $r['SURV_DT'],
                        "userDetails" => $r['SM_NAME'] . " - [" . $r['SM_CD'] . "]",
                        "houseVisit" => $r['HOUSV_CNT']
                    ];
                }
                echo json_encode($resultData);
            } else {
                $e = oci_error($curs); // For oci_execute errors pass the statementhandle
                // echo "No Data Found";
            }
        } else {
            $e = oci_error($stid); // For oci_execute errors pass the statementhandle
            // echo htmlentities($e['message']);
            exit;
        }
    } else {
        $e = oci_error($conn);  // For oci_parse errors pass the connection handle
        echo htmlentities($e['message']);
    }

    oci_free_statement($stid);
    oci_free_statement($curs);
    oci_close($conn);
}

function getCommonData1($conn, $postData)
{
    $resultData = [];
    $i_PType = $postData["parent_type"];
    $i_Parent = $postData["parent"];




    $curs = oci_new_cursor($conn);
    $query = "begin PKGPH_SM_SURVEY_TEST.PRC_POPU_PARAM 
	(
        :i_PType,   
        :i_Parent,
        :cS_Data
	); 
	end;";
    $stid = oci_parse($conn, $query);
    $data = "";
    if ($stid) {
        oci_bind_by_name($stid, ':i_PType', $i_PType, 100);
        oci_bind_by_name($stid, ':i_Parent', $i_Parent, 100);
        oci_bind_by_name($stid, ":cS_Data", $curs, -1, OCI_B_CURSOR);
        $r = oci_execute($stid);
        if ($r) {
            $r1 = oci_execute($curs);
            if ($r1) {
                while (($r = oci_fetch_array($curs, OCI_ASSOC + OCI_RETURN_NULLS)) != false) {
                    $resultData[] = $r;
                }
                echo json_encode($resultData);
            } else {
                $e = oci_error($curs); // For oci_execute errors pass the statementhandle
                // echo "No Data Found";
            }
        } else {
            $e = oci_error($stid); // For oci_execute errors pass the statementhandle
            // echo htmlentities($e['message']);
            exit;
        }
    } else {
        $e = oci_error($conn);  // For oci_parse errors pass the connection handle
        echo htmlentities($e['message']);
    }

    oci_free_statement($stid);
    oci_free_statement($curs);
    oci_close($conn);
}

function getWorkPlanData($conn, $postData)
{
    $I_MONTH = $postData['month_cd'];
    $I_YR = $postData['year_cd'];
    $i_user_id =  $postData['user_id'];
    $resultData = [];
    $curs = oci_new_cursor($conn);
    $query = "begin pkg_work_plan_dp.PRC_POPU_PLAN_DATA 
	(
        :I_MONTH,   
        :I_YR,  
        :i_user_id,  
        :cS_Data,
        :o_msg,
        :o_errmsg
	); 
	end;";
    $stid = oci_parse($conn, $query);
    $data = "";
    if ($stid) {
        oci_bind_by_name($stid, ':I_MONTH', $I_MONTH, 100);
        oci_bind_by_name($stid, ':I_YR', $I_YR, 100);
        oci_bind_by_name($stid, ':i_user_id', $i_user_id, 100);
        oci_bind_by_name($stid, ":cS_Data", $curs, -1, OCI_B_CURSOR);
        oci_bind_by_name($stid, ':o_msg', $o_msg, 100);
        oci_bind_by_name($stid, ':o_errmsg', $o_errmsg, 100);
        $r = oci_execute($stid);
        if ($r) {
            $r1 = oci_execute($curs);
            if ($r1) {
                while (($r = oci_fetch_array($curs, OCI_ASSOC + OCI_RETURN_NULLS)) != false) {
                    $resultData[$r["PLAN_DT"]][] = $r;
                }
                echo json_encode($resultData);
            } else {
                $e = oci_error($curs); // For oci_execute errors pass the statementhandle
                echo "No Data Found";
            }
        } else {
            $e = oci_error($stid); // For oci_execute errors pass the statementhandle
            echo htmlentities($e['message']);
            exit;
        }
    } else {
        $e = oci_error($conn);  // For oci_parse errors pass the connection handle
        echo htmlentities($e['message']);
    }

    oci_free_statement($stid);
    oci_free_statement($curs);
    oci_close($conn);
}

function saveSurvey($conn, $reqData)
{
    $reqData = json_decode($reqData["serverdata"], true);

    // get distance from last survey start------------

    $symptomsDataArr = $reqData["data"]["symptoms_data"];
    $i_user_id_       = $symptomsDataArr[0]["user_id"];
    $i_survey_date_   = date('d-m-Y', strtotime($symptomsDataArr[0]["timeStamp"]));

    $o_latitude2_    = $symptomsDataArr[0]["latitude"] ?? 0;
    $o_longitude2_   = $symptomsDataArr[0]["longitude"] ?? 0;
    if ($o_latitude2_ == 0 || $o_latitude2_ == "") {
        $distanceCovered = 0;
    } else {

        $distanceCovered = getDistanceBetweenSurveys($conn, $i_survey_date_, $o_latitude2_, $o_longitude2_, $i_user_id_);
    }

    // get distance from last survey end------------










    $famHeadArr = $reqData["data"]["head_data"];

    $i_Family_Survey_Type_arr = [];
    $i_FamilyId_arr          = [];
    $i_FamilyHead_arr        = [];
    $i_FamilyPhone_arr       = [];
    $i_FamilyHouseNo_arr     = [];
    $i_FamilyAddress_arr     = [];
    $i_FamilyGaonPanch_arr   = [];
    $i_FamilyBlock_arr       = [];
    $i_FamilyCityCd_arr      = [];
    $i_FamilyDistCd_arr      = [];
    $i_FamilyStateCd_arr     = [];
    $i_FamilyPin_arr         = [];
    $i_FamilyUserId_arr      = [];
    $i_FamilyTimestamp_arr   = [];











    $i_Family_Survey_Type_arr[]   = $famHeadArr["SURVEY_TYPE"];
    $i_FamilyId_arr[]          = $famHeadArr["SSFM_ID"];
    $i_FamilyHead_arr[]        = $famHeadArr["SSFM_HEAD_NAME"];
    $i_FamilyPhone_arr[]       = $famHeadArr["SSFM_CONTACT_NO"];
    $i_FamilyHouseNo_arr[]     = $famHeadArr["SSFM_HOUSE_NO"];
    $i_FamilyAddress_arr[]     = $famHeadArr["SSFM_ADDR"];
    $i_FamilyGaonPanch_arr[]   = $famHeadArr["SSFM_GAON_PNCHYT"];
    $i_FamilyBlock_arr[]       = $famHeadArr["SSFM_BLOCK_CODE"];
    $i_FamilyCityCd_arr[]      = $famHeadArr["SSFM_CITY_CODE"];
    $i_FamilyDistCd_arr[]      = $famHeadArr["SSFM_DIST_CODE"];
    $i_FamilyStateCd_arr[]     = $famHeadArr["SSFM_STATE_CODE"];
    $i_FamilyPin_arr[]         = $famHeadArr["SSFM_PIN"];
    $i_FamilyUserId_arr[]      = $famHeadArr["user_id"];
    $i_FamilyTimestamp_arr[]   = $famHeadArr["timestamp"];








    $famMemberArr = $reqData["data"]["member_data"];
    $i_MemberId_arr           = [];
    $i_MemberFamilyId_arr     = [];
    $i_MemberName_arr         = [];
    $i_MemberGender_arr       = [];
    $i_MemberDob_arr          = [];
    $i_MemberAgeYr_arr        = [];
    $i_MemberAgeMn_arr        = [];
    $i_MemberAgeDy_arr        = [];
    $i_MemberContactNo_arr    = [];
    $i_MemberAreaLocality_arr = [];
    $i_MemberGaonPanch_arr    = [];
    $i_MemberBlock_arr        = [];
    $i_MemberCityCd_arr       = [];
    $i_MemberDistCd_arr       = [];
    $i_MemberStateCd_arr      = [];
    $i_MemberPin_arr          = [];
    $i_MemberUserId_arr       = [];
    $i_MemberTimeStamp_arr    = [];



    foreach ($famMemberArr as $key => $value) {



        $i_Member_Survey_Type_arr[] = $value["SURVEY_TYPE"];
        $i_MemberId_arr[]           = $value["SSR_REGN_NUM"];
        $i_MemberFamilyId_arr[]     = $value["family_id"];
        $i_MemberName_arr[]         = $value["SSR_PATIENT_NAME"];
        $i_MemberGender_arr[]       = $value["SSR_GENDER"];
        $i_MemberDob_arr[]          = $value["SSR_DOB"];
        $i_MemberAgeYr_arr[]        = $value["SSR_AGE_YR"];
        $i_MemberAgeMn_arr[]        = $value["SSR_AGE_MN"];
        $i_MemberAgeDy_arr[]        = $value["SSR_AGE_DY"];
        $i_MemberContactNo_arr[]    = isset($value["SSR_CONTACT_NO"]) ? '' : $value["SSR_CONTACT_NO"];
        $i_MemberAreaLocality_arr[] = $value["SSR_AREA_LOCALITY"];
        $i_MemberGaonPanch_arr[]    = $value["SSR_PANCHAYAT_NAME"];
        $i_MemberBlock_arr[]        = $value["SSR_BLOCK_NAME"];
        $i_MemberCityCd_arr[]       =  $famHeadArr["SSFM_CITY_CODE"];
        $i_MemberDistCd_arr[]       =   $famHeadArr["SSFM_DIST_CODE"];
        $i_MemberStateCd_arr[]      =   $famHeadArr["SSFM_STATE_CODE"];
        $i_MemberPin_arr[]          =   $famHeadArr["SSFM_PIN"];
        $i_MemberUserId_arr[]       = $value["SSR_CRT_USER_ID"];
        $i_MemberTimeStamp_arr[]    = $value["SSR_LST_UPD_DT"];
    }









    $symptomsDataArr = $reqData["data"]["symptoms_data"];




    $i_SurveyGroupId_arr     = [];

    $i_ConsentFileName_arr   = [];


    $i_SurveyMemberId_arr    = [];
    $i_SurveyFamilyId_arr    = [];
    $i_SurveyId_arr          = [];
    $i_SurveyType_arr     = [];
    $i_SurveyMemberName_arr  = [];
    $i_SurveyIsSmoking_arr   = [];
    $i_SurveyIsAlcohol_arr   = [];
    $i_SurveyLatitude_arr    = [];
    $i_SurveyLongitude_arr   = [];
    $i_SurveyPresDia_arr     = [];
    $i_SurveyPresSys_arr     = [];
    $i_SurveyGlocuType_arr   = [];
    $i_SurveyGlocuValue_arr  = [];
    $i_SurveyHasAaa_arr      = [];
    $i_SurveyHasPmjay_arr    = [];
    $i_SurveyBookTele_arr    = [];
    $i_SurveyBookOpd_arr     = [];
    $i_SurveyBookAmbu_arr    = [];
    $i_SurveyUserId_arr      = [];
    $i_SurveyTimeStamp_arr   = [];
    $i_DistanceCovered_arr   = [];

    $i_patAgreedToHouseVisit_arr    = [];
    $i_patAgreedVisitDate_arr       = [];





    $i_SymptomSurveyId_arr    =   [];
    $i_SymptomCtgr_arr        =   [];
    $i_SymptomAttrCode_arr    =   [];
    $i_SymptomAttrValue_arr   =   [];
    $i_SymptomTimeStamp_arr   =   [];
    $i_SymptomUserId_arr      =   [];


    foreach ($symptomsDataArr as $key => $value) {

        $i_SurveyType_arr[]     = $value["SURVEY_TYPE"];
        $i_SurveyGroupId_arr[]     = $value["group_surveyid"];
        $i_ConsentFileName_arr[]     = $value["group_surveyid"] . ".mp4";
        $i_SurveyMemberId_arr[]    = $value["member_id"];
        $i_SurveyFamilyId_arr[]    = $value["family_id"];
        $i_SurveyId_arr[]          = $value["memberSurvey_id"];
        $i_SurveyMemberName_arr[]  = $value["member_name"];
        $i_SurveyIsSmoking_arr[]   = $value["smoking"];
        $i_SurveyIsAlcohol_arr[]   = $value["alcohol"];
        $i_SurveyLatitude_arr[]    = floatval($value["latitude"]);
        $i_SurveyLongitude_arr[]   = floatval($value["longitude"]);
        $i_SurveyPresDia_arr[]     = isset($value["dia"]) ? 0 : $value["dia"];
        $i_SurveyPresSys_arr[]     = isset($value["sys"]) ? 0 : $value["sys"]; //$value["sys"];
        $i_SurveyGlocuType_arr[]   = $value["type"];
        $i_SurveyGlocuValue_arr[]  = isset($value["value"]) ? 0 : $value["value"];
        $i_SurveyHasAaa_arr[]      = $value["atal_amrit"];
        $i_SurveyHasPmjay_arr[]    = $value["ayushman_bharat"];
        $i_SurveyBookTele_arr[]    = $value["telemedicine_booked"];
        $i_SurveyBookOpd_arr[]     = $value["opd_booked"];
        $i_SurveyBookAmbu_arr[]    = $value["ambulance_booked"];
        $i_SurveyUserId_arr[]      = $value["user_id"];
        $i_SurveyTimeStamp_arr[]   = $value["timeStamp"];

        $i_patAgreedToHouseVisit_arr[] = isset($value["agreedVisit"]) ? $value["agreedVisit"] : "0";
        $i_patAgreedVisitDate_arr[] =   isset($value["agreedDate"]) ?  date("d/m/Y", strtotime($value["agreedDate"])) : "";



        $i_DistanceCovered_arr[]   =  $distanceCovered;


        //echo json_encode(['status' => "0", 'message' => "Test ".json_encode( $i_patAgreedVisitDate_arr)]);



        // commentend on 29thMay2023
        // $symptomsDetailArr = $value["symptom_details"];
        // foreach ($symptomsDetailArr as $key => $value) {
        //     $i_SymptomSurveyId_arr[]    =   $value["memberSurvey_id"];
        //     $i_SymptomCtgr_arr[]        =   $value["PRT_DESC"];
        //     $i_SymptomAttrCode_arr[]    =   $value["ATR_CODE"];
        //     $i_SymptomAttrValue_arr[]   =   1;
        //     $i_SymptomUserId_arr[]      =   $value["user_id"];
        //     $i_SymptomTimeStamp_arr[]   =   $value["timeStamp"];
        // }

        // added on 29thMay2023
        if (isset($value["symptom_details"])) {
            $symptomsDetailArr = $value["symptom_details"];
            foreach ($symptomsDetailArr as $key => $value) {
                $i_SymptomSurveyId_arr[]    =   $value["memberSurvey_id"];
                $i_SymptomCtgr_arr[]        =   $value["PRT_DESC"];
                $i_SymptomAttrCode_arr[]    =   $value["ATR_CODE"];
                $i_SymptomAttrValue_arr[]   =   1;
                $i_SymptomUserId_arr[]      =   $value["user_id"];
                $i_SymptomTimeStamp_arr[]   =   $value["timeStamp"];
            }
        } else {

            // for no symptoms
            $i_SymptomSurveyId_arr[]    =   $value["memberSurvey_id"];
            $i_SymptomCtgr_arr[]        =   "Others";
            $i_SymptomAttrCode_arr[]    =   "SRV22_019_001";
            $i_SymptomAttrValue_arr[]   =   1;
            $i_SymptomUserId_arr[]      =   $value["user_id"];
            $i_SymptomTimeStamp_arr[]   =   $value["timeStamp"];
        }
    }






    $i_Family_Survey_Type_size = sizeof($i_Family_Survey_Type_arr) == 0 ? 1 : sizeof($i_Family_Survey_Type_arr);
    $i_FamilyId_size = sizeof($i_FamilyId_arr) == 0 ? 1 : sizeof($i_FamilyId_arr);
    $i_FamilyHead_size = sizeof($i_FamilyHead_arr) == 0 ? 1 : sizeof($i_FamilyHead_arr);
    $i_FamilyPhone_size = sizeof($i_FamilyPhone_arr) == 0 ? 1 : sizeof($i_FamilyPhone_arr);
    $i_FamilyHouseNo_size = sizeof($i_FamilyHouseNo_arr) == 0 ? 1 : sizeof($i_FamilyHouseNo_arr);
    $i_FamilyAddress_size = sizeof($i_FamilyAddress_arr) == 0 ? 1 : sizeof($i_FamilyAddress_arr);
    $i_FamilyGaonPanch_size = sizeof($i_FamilyGaonPanch_arr) == 0 ? 1 : sizeof($i_FamilyGaonPanch_arr);
    $i_FamilyBlock_size = sizeof($i_FamilyBlock_arr) == 0 ? 1 : sizeof($i_FamilyBlock_arr);
    $i_FamilyCityCd_size = sizeof($i_FamilyCityCd_arr) == 0 ? 1 : sizeof($i_FamilyCityCd_arr);
    $i_FamilyDistCd_size = sizeof($i_FamilyDistCd_arr) == 0 ? 1 : sizeof($i_FamilyDistCd_arr);
    $i_FamilyStateCd_size = sizeof($i_FamilyStateCd_arr) == 0 ? 1 : sizeof($i_FamilyStateCd_arr);
    $i_FamilyPin_size = sizeof($i_FamilyPin_arr) == 0 ? 1 : sizeof($i_FamilyPin_arr);
    $i_FamilyUserId_size = sizeof($i_FamilyUserId_arr) == 0 ? 1 : sizeof($i_FamilyUserId_arr);
    $i_FamilyTimestamp_size = sizeof($i_FamilyTimestamp_arr) == 0 ? 1 : sizeof($i_FamilyTimestamp_arr);


    $i_Member_Survey_Type_size = sizeof($i_Member_Survey_Type_arr) == 0 ? 1 : sizeof($i_Member_Survey_Type_arr);
    $i_MemberId_size = sizeof($i_MemberId_arr) == 0 ? 1 : sizeof($i_MemberId_arr);
    $i_MemberFamilyId_size = sizeof($i_MemberFamilyId_arr) == 0 ? 1 : sizeof($i_MemberFamilyId_arr);
    $i_MemberName_size = sizeof($i_MemberName_arr) == 0 ? 1 : sizeof($i_MemberName_arr);
    $i_MemberGender_size = sizeof($i_MemberGender_arr) == 0 ? 1 : sizeof($i_MemberGender_arr);
    $i_MemberDob_size = sizeof($i_MemberDob_arr) == 0 ? 1 : sizeof($i_MemberDob_arr);
    $i_MemberAgeYr_size = sizeof($i_MemberAgeYr_arr) == 0 ? 1 : sizeof($i_MemberAgeYr_arr);
    $i_MemberAgeMn_size = sizeof($i_MemberAgeMn_arr) == 0 ? 1 : sizeof($i_MemberAgeMn_arr);
    $i_MemberAgeDy_size = sizeof($i_MemberAgeDy_arr) == 0 ? 1 : sizeof($i_MemberAgeDy_arr);
    $i_MemberContactNo_size = sizeof($i_MemberContactNo_arr) == 0 ? 1 : sizeof($i_MemberContactNo_arr);
    $i_MemberAreaLocality_size = sizeof($i_MemberAreaLocality_arr) == 0 ? 1 : sizeof($i_MemberAreaLocality_arr);
    $i_MemberGaonPanch_size = sizeof($i_MemberGaonPanch_arr) == 0 ? 1 : sizeof($i_MemberGaonPanch_arr);
    $i_MemberBlock_size = sizeof($i_MemberBlock_arr) == 0 ? 1 : sizeof($i_MemberBlock_arr);
    $i_MemberCityCd_size = sizeof($i_MemberCityCd_arr) == 0 ? 1 : sizeof($i_MemberCityCd_arr);
    $i_MemberDistCd_size = sizeof($i_MemberDistCd_arr) == 0 ? 1 : sizeof($i_MemberDistCd_arr);
    $i_MemberStateCd_size = sizeof($i_MemberStateCd_arr) == 0 ? 1 : sizeof($i_MemberStateCd_arr);
    $i_MemberPin_size = sizeof($i_MemberPin_arr) == 0 ? 1 : sizeof($i_MemberPin_arr);
    $i_MemberUserId_size = sizeof($i_MemberUserId_arr) == 0 ? 1 : sizeof($i_MemberUserId_arr);
    $i_MemberTimeStamp_size = sizeof($i_MemberTimeStamp_arr) == 0 ? 1 : sizeof($i_MemberTimeStamp_arr);
    $i_SurveyGroupId_size = sizeof($i_SurveyGroupId_arr) == 0 ? 1 : sizeof($i_SurveyGroupId_arr);
    $i_SurveyMemberId_size = sizeof($i_SurveyMemberId_arr) == 0 ? 1 : sizeof($i_SurveyMemberId_arr);
    $i_SurveyFamilyId_size = sizeof($i_SurveyFamilyId_arr) == 0 ? 1 : sizeof($i_SurveyFamilyId_arr);

    $i_SurveyId_size = sizeof($i_SurveyId_arr) == 0 ? 1 : sizeof($i_SurveyId_arr);
    $i_SurveyType_arr_size = sizeof($i_SurveyType_arr) == 0 ? 1 : sizeof($i_SurveyType_arr);

    $i_SurveyMemberName_size = sizeof($i_SurveyMemberName_arr) == 0 ? 1 : sizeof($i_SurveyMemberName_arr);
    $i_SurveyIsSmoking_size = sizeof($i_SurveyIsSmoking_arr) == 0 ? 1 : sizeof($i_SurveyIsSmoking_arr);
    $i_SurveyIsAlcohol_size = sizeof($i_SurveyIsAlcohol_arr) == 0 ? 1 : sizeof($i_SurveyIsAlcohol_arr);
    $i_SurveyLatitude_size = sizeof($i_SurveyLatitude_arr) == 0 ? 1 : sizeof($i_SurveyLatitude_arr);
    $i_SurveyLongitude_size = sizeof($i_SurveyLongitude_arr) == 0 ? 1 : sizeof($i_SurveyLongitude_arr);
    $i_SurveyPresDia_size = sizeof($i_SurveyPresDia_arr) == 0 ? 1 : sizeof($i_SurveyPresDia_arr);
    $i_SurveyPresSys_size = sizeof($i_SurveyPresSys_arr) == 0 ? 1 : sizeof($i_SurveyPresSys_arr);
    $i_SurveyGlocuType_size = sizeof($i_SurveyGlocuType_arr) == 0 ? 1 : sizeof($i_SurveyGlocuType_arr);
    $i_SurveyGlocuValue_size = sizeof($i_SurveyGlocuValue_arr) == 0 ? 1 : sizeof($i_SurveyGlocuValue_arr);
    $i_SurveyHasAaa_size = sizeof($i_SurveyHasAaa_arr) == 0 ? 1 : sizeof($i_SurveyHasAaa_arr);
    $i_SurveyHasPmjay_size = sizeof($i_SurveyHasPmjay_arr) == 0 ? 1 : sizeof($i_SurveyHasPmjay_arr);
    $i_SurveyBookTele_size = sizeof($i_SurveyBookTele_arr) == 0 ? 1 : sizeof($i_SurveyBookTele_arr);
    $i_SurveyBookOpd_size = sizeof($i_SurveyBookOpd_arr) == 0 ? 1 : sizeof($i_SurveyBookOpd_arr);
    $i_SurveyBookAmbu_size = sizeof($i_SurveyBookAmbu_arr) == 0 ? 1 : sizeof($i_SurveyBookAmbu_arr);
    $i_SurveyUserId_size = sizeof($i_SurveyUserId_arr) == 0 ? 1 : sizeof($i_SurveyUserId_arr);
    $i_SurveyTimeStamp_size = sizeof($i_SurveyTimeStamp_arr) == 0 ? 1 : sizeof($i_SurveyTimeStamp_arr);


    $i_patAgreedToHouseVisit_size = sizeof($i_patAgreedToHouseVisit_arr) == 0 ? 1 : sizeof($i_patAgreedToHouseVisit_arr);
    $i_patAgreedVisitDate_size = sizeof($i_patAgreedVisitDate_arr) == 0 ? 1 : sizeof($i_patAgreedVisitDate_arr);






    $i_DistanceCovered_size = sizeof($i_DistanceCovered_arr) == 0 ? 1 : sizeof($i_DistanceCovered_arr);





    $i_SymptomSurveyId_size = sizeof($i_SymptomSurveyId_arr) == 0 ? 1 : sizeof($i_SymptomSurveyId_arr);
    $i_SymptomCtgr_size = sizeof($i_SymptomCtgr_arr) == 0 ? 1 : sizeof($i_SymptomCtgr_arr);
    $i_SymptomAttrCode_size = sizeof($i_SymptomAttrCode_arr) == 0 ? 1 : sizeof($i_SymptomAttrCode_arr);
    $i_SymptomAttrValue_size = sizeof($i_SymptomAttrValue_arr) == 0 ? 1 : sizeof($i_SymptomAttrValue_arr);
    $i_SymptomUserId_size = sizeof($i_SymptomUserId_arr) == 0 ? 1 : sizeof($i_SymptomUserId_arr);
    $i_SymptomTimeStamp_size = sizeof($i_SymptomTimeStamp_arr) == 0 ? 1 : sizeof($i_SymptomTimeStamp_arr);




    $query = "begin PKGPH_SM_SURVEY_TEST.PRC_I_SURVEY_2023
	(
         :i_Family_Survey_Type
        ,:i_FamilyId          
        ,:i_FamilyHead        
        ,:i_FamilyPhone       
        ,:i_FamilyHouseNo     
        ,:i_FamilyAddress     
        ,:i_FamilyGaonPanch   
        ,:i_FamilyBlock       
        ,:i_FamilyCityCd      
        ,:i_FamilyDistCd      
        ,:i_FamilyStateCd     
        ,:i_FamilyPin         
        ,:i_FamilyUserId      
        ,:i_FamilyTimestamp   
        ,:i_Member_Survey_Type     
        ,:i_MemberId          
        ,:i_MemberFamilyId    
        ,:i_MemberName        
        ,:i_MemberGender      
        ,:i_MemberDob         
        ,:i_MemberAgeYr       
        ,:i_MemberAgeMn       
        ,:i_MemberAgeDy       
        ,:i_MemberContactNo   
        ,:i_MemberAreaLocality 
        ,:i_MemberGaonPanch   
        ,:i_MemberBlock       
        ,:i_MemberCityCd      
        ,:i_MemberDistCd      
        ,:i_MemberStateCd     
        ,:i_MemberPin         
        ,:i_MemberUserId      
        ,:i_MemberTimeStamp   
        ,:i_SurveyGroupId     
        ,:i_SurveyMemberId    
        ,:i_SurveyFamilyId    
        ,:i_SurveyId        
        ,:i_SurveyType  
        ,:i_SurveyMemberName  
        ,:i_SurveyIsSmoking   
        ,:i_SurveyIsAlcohol   
        ,:i_SurveyLatitude    
        ,:i_SurveyLongitude   
        ,:i_SurveyPresDia     
        ,:i_SurveyPresSys     
        ,:i_SurveyGlocuType   
        ,:i_SurveyGlocuValue  
        ,:i_SurveyHasAaa      
        ,:i_SurveyHasPmjay    
        ,:i_SurveyBookTele    
        ,:i_SurveyBookOpd     
        ,:i_SurveyBookAmbu    
        ,:i_SurveyUserId      
        ,:i_SurveyTimeStamp
        ,:i_DistanceCovered   
        ,:i_SymptomSurveyId   
        ,:i_SymptomCtgr       
        ,:i_SymptomAttrCode   
        ,:i_SymptomAttrValue  
        ,:i_SymptomUserId     
        ,:i_SymptomTimeStamp
        ,:i_patAgreedToHouseVisit
        ,:i_patAgreedVisitDate 
        ,:o_Msg
        ,:o_RetMsg
    );
	end;";
    $stid = oci_parse($conn, $query);


    if (!$stid) {
        $e = oci_error($conn);  // For oci_parse errors pass the connection handle
        echo json_encode(['status' => "0", 'message' => "ERROR_PARSE"]);
        exit();
    }








    oci_bind_array_by_name($stid, ":i_Family_Survey_Type", $i_Family_Survey_Type_arr, $i_Family_Survey_Type_size, -1, SQLT_CHR);
    oci_bind_array_by_name($stid, ":i_FamilyId", $i_FamilyId_arr, $i_FamilyId_size, -1, SQLT_CHR);
    oci_bind_array_by_name($stid, ":i_FamilyHead", $i_FamilyHead_arr, $i_FamilyHead_size, -1, SQLT_CHR);
    oci_bind_array_by_name($stid, ":i_FamilyPhone", $i_FamilyPhone_arr, $i_FamilyPhone_size, -1, SQLT_CHR);
    oci_bind_array_by_name($stid, ":i_FamilyHouseNo", $i_FamilyHouseNo_arr, $i_FamilyHouseNo_size, -1, SQLT_CHR);
    oci_bind_array_by_name($stid, ":i_FamilyAddress", $i_FamilyAddress_arr, $i_FamilyAddress_size, -1, SQLT_CHR);
    oci_bind_array_by_name($stid, ":i_FamilyGaonPanch", $i_FamilyGaonPanch_arr, $i_FamilyGaonPanch_size, -1, SQLT_CHR);
    oci_bind_array_by_name($stid, ":i_FamilyBlock", $i_FamilyBlock_arr, $i_FamilyBlock_size, -1, SQLT_CHR);
    oci_bind_array_by_name($stid, ":i_FamilyCityCd", $i_FamilyCityCd_arr, $i_FamilyCityCd_size, -1, SQLT_CHR);
    oci_bind_array_by_name($stid, ":i_FamilyDistCd", $i_FamilyDistCd_arr, $i_FamilyDistCd_size, -1, SQLT_CHR);
    oci_bind_array_by_name($stid, ":i_FamilyStateCd", $i_FamilyStateCd_arr, $i_FamilyStateCd_size, -1, SQLT_CHR);
    oci_bind_array_by_name($stid, ":i_FamilyPin", $i_FamilyPin_arr, $i_FamilyPin_size, -1, SQLT_CHR);
    oci_bind_array_by_name($stid, ":i_FamilyUserId", $i_FamilyUserId_arr, $i_FamilyUserId_size, -1, SQLT_CHR);
    oci_bind_array_by_name($stid, ":i_FamilyTimestamp", $i_FamilyTimestamp_arr, $i_FamilyTimestamp_size, -1, SQLT_CHR);

    oci_bind_array_by_name($stid, ":i_Member_Survey_Type", $i_Member_Survey_Type_arr, $i_Member_Survey_Type_size, -1, SQLT_CHR);
    oci_bind_array_by_name($stid, ":i_MemberId", $i_MemberId_arr, $i_MemberId_size, -1, SQLT_CHR);
    oci_bind_array_by_name($stid, ":i_MemberFamilyId", $i_MemberFamilyId_arr, $i_MemberFamilyId_size, -1, SQLT_CHR);
    oci_bind_array_by_name($stid, ":i_MemberName", $i_MemberName_arr, $i_MemberName_size, -1, SQLT_CHR);
    oci_bind_array_by_name($stid, ":i_MemberGender", $i_MemberGender_arr, $i_MemberGender_size, -1, SQLT_CHR);
    oci_bind_array_by_name($stid, ":i_MemberDob", $i_MemberDob_arr, $i_MemberDob_size, -1, SQLT_CHR);
    oci_bind_array_by_name($stid, ":i_MemberAgeYr", $i_MemberAgeYr_arr, $i_MemberAgeYr_size, -1, SQLT_FLT);
    oci_bind_array_by_name($stid, ":i_MemberAgeMn", $i_MemberAgeMn_arr, $i_MemberAgeMn_size, -1, SQLT_FLT);
    oci_bind_array_by_name($stid, ":i_MemberAgeDy", $i_MemberAgeDy_arr, $i_MemberAgeDy_size, -1, SQLT_FLT);
    oci_bind_array_by_name($stid, ":i_MemberContactNo", $i_MemberContactNo_arr, $i_MemberContactNo_size, -1, SQLT_CHR);
    oci_bind_array_by_name($stid, ":i_MemberAreaLocality", $i_MemberAreaLocality_arr, $i_MemberAreaLocality_size, -1, SQLT_CHR);
    oci_bind_array_by_name($stid, ":i_MemberGaonPanch", $i_MemberGaonPanch_arr, $i_MemberGaonPanch_size, -1, SQLT_CHR);
    oci_bind_array_by_name($stid, ":i_MemberBlock", $i_MemberBlock_arr, $i_MemberBlock_size, -1, SQLT_CHR);
    oci_bind_array_by_name($stid, ":i_MemberCityCd", $i_MemberCityCd_arr, $i_MemberCityCd_size, -1, SQLT_CHR);
    oci_bind_array_by_name($stid, ":i_MemberDistCd", $i_MemberDistCd_arr, $i_MemberDistCd_size, -1, SQLT_CHR);
    oci_bind_array_by_name($stid, ":i_MemberStateCd", $i_MemberStateCd_arr, $i_MemberStateCd_size, -1, SQLT_CHR);
    oci_bind_array_by_name($stid, ":i_MemberPin", $i_MemberPin_arr, $i_MemberPin_size, -1, SQLT_CHR);
    oci_bind_array_by_name($stid, ":i_MemberUserId", $i_MemberUserId_arr, $i_MemberUserId_size, -1, SQLT_CHR);
    oci_bind_array_by_name($stid, ":i_MemberTimeStamp", $i_MemberTimeStamp_arr, $i_MemberTimeStamp_size, -1, SQLT_CHR);
    oci_bind_array_by_name($stid, ":i_SurveyGroupId", $i_SurveyGroupId_arr, $i_SurveyGroupId_size, -1, SQLT_CHR);
    oci_bind_array_by_name($stid, ":i_SurveyMemberId", $i_SurveyMemberId_arr, $i_SurveyMemberId_size, -1, SQLT_CHR);
    oci_bind_array_by_name($stid, ":i_SurveyFamilyId", $i_SurveyFamilyId_arr, $i_SurveyFamilyId_size, -1, SQLT_CHR);

    oci_bind_array_by_name($stid, ":i_SurveyId", $i_SurveyId_arr, $i_SurveyId_size, -1, SQLT_CHR);
    oci_bind_array_by_name($stid, ":i_SurveyType", $i_SurveyType_arr, $i_SurveyType_arr_size, -1, SQLT_CHR);
    oci_bind_array_by_name($stid, ":i_SurveyMemberName", $i_SurveyMemberName_arr, $i_SurveyMemberName_size, -1, SQLT_CHR);
    oci_bind_array_by_name($stid, ":i_SurveyIsSmoking", $i_SurveyIsSmoking_arr, $i_SurveyIsSmoking_size, -1, SQLT_CHR);
    oci_bind_array_by_name($stid, ":i_SurveyIsAlcohol", $i_SurveyIsAlcohol_arr, $i_SurveyIsAlcohol_size, -1, SQLT_CHR);
    oci_bind_array_by_name($stid, ":i_SurveyLatitude", $i_SurveyLatitude_arr, $i_SurveyLatitude_size, -1, SQLT_CHR);
    oci_bind_array_by_name($stid, ":i_SurveyLongitude", $i_SurveyLongitude_arr, $i_SurveyLongitude_size, -1, SQLT_CHR);
    oci_bind_array_by_name($stid, ":i_SurveyPresDia", $i_SurveyPresDia_arr, $i_SurveyPresDia_size, -1, SQLT_CHR);
    oci_bind_array_by_name($stid, ":i_SurveyPresSys", $i_SurveyPresSys_arr, $i_SurveyPresSys_size, -1, SQLT_CHR);
    oci_bind_array_by_name($stid, ":i_SurveyGlocuType", $i_SurveyGlocuType_arr, $i_SurveyGlocuType_size, -1, SQLT_CHR);
    oci_bind_array_by_name($stid, ":i_SurveyGlocuValue", $i_SurveyGlocuValue_arr, $i_SurveyGlocuValue_size, -1, SQLT_CHR);
    oci_bind_array_by_name($stid, ":i_SurveyHasAaa", $i_SurveyHasAaa_arr, $i_SurveyHasAaa_size, -1, SQLT_CHR);
    oci_bind_array_by_name($stid, ":i_SurveyHasPmjay", $i_SurveyHasPmjay_arr, $i_SurveyHasPmjay_size, -1, SQLT_CHR);
    oci_bind_array_by_name($stid, ":i_SurveyBookTele", $i_SurveyBookTele_arr, $i_SurveyBookTele_size, -1, SQLT_CHR);
    oci_bind_array_by_name($stid, ":i_SurveyBookOpd", $i_SurveyBookOpd_arr, $i_SurveyBookOpd_size, -1, SQLT_CHR);
    oci_bind_array_by_name($stid, ":i_SurveyBookAmbu", $i_SurveyBookAmbu_arr, $i_SurveyBookAmbu_size, -1, SQLT_CHR);
    oci_bind_array_by_name($stid, ":i_SurveyUserId", $i_SurveyUserId_arr, $i_SurveyUserId_size, -1, SQLT_CHR);
    oci_bind_array_by_name($stid, ":i_SurveyTimeStamp", $i_SurveyTimeStamp_arr, $i_SurveyTimeStamp_size, -1, SQLT_CHR);
    oci_bind_array_by_name($stid, ":i_DistanceCovered", $i_DistanceCovered_arr, $i_DistanceCovered_size, -1, SQLT_CHR);





    oci_bind_array_by_name($stid, ":i_SymptomSurveyId", $i_SymptomSurveyId_arr, $i_SymptomSurveyId_size, -1, SQLT_CHR);
    oci_bind_array_by_name($stid, ":i_SymptomCtgr", $i_SymptomCtgr_arr, $i_SymptomCtgr_size, -1, SQLT_CHR);
    oci_bind_array_by_name($stid, ":i_SymptomAttrCode", $i_SymptomAttrCode_arr, $i_SymptomAttrCode_size, -1, SQLT_CHR);
    oci_bind_array_by_name($stid, ":i_SymptomAttrValue", $i_SymptomAttrValue_arr, $i_SymptomAttrValue_size, -1, SQLT_CHR);
    oci_bind_array_by_name($stid, ":i_SymptomUserId", $i_SymptomUserId_arr, $i_SymptomUserId_size, -1, SQLT_CHR);
    oci_bind_array_by_name($stid, ":i_SymptomTimeStamp", $i_SymptomTimeStamp_arr, $i_SymptomTimeStamp_size, -1, SQLT_CHR);
    oci_bind_array_by_name($stid, ":i_patAgreedToHouseVisit", $i_patAgreedToHouseVisit_arr, $i_patAgreedToHouseVisit_size, -1, SQLT_CHR);
    oci_bind_array_by_name($stid, ":i_patAgreedVisitDate", $i_patAgreedVisitDate_arr, $i_patAgreedVisitDate_size, -1, SQLT_CHR);
    oci_bind_by_name($stid, ":o_Msg", $o_status, 100);
    oci_bind_by_name($stid, ":o_RetMsg", $o_msg, 100);
    $r = oci_execute($stid, OCI_NO_AUTO_COMMIT);
    if (!$r) {
        $e = oci_error($stid); // For oci_execute errors pass the statementhandle
        echo json_encode(['status' => 0, 'message' => $e['message'] . "zzzzzzz1111"]);
        unlinkConsentFile($i_ConsentFileName_arr);


        exit();
    }

    if ($o_status > 0) {
        oci_commit($conn);
        echo json_encode(['status' => 1, 'message' => $o_msg]);
    } else {
        oci_rollback($conn);

        echo json_encode(['status' => 0, 'message' => $o_msg]);
        unlinkConsentFile($i_ConsentFileName_arr);
    }


    oci_free_statement($stid);
    oci_close($conn);
}

function getSymptomsList($conn, $postData)
{
    $I_PARAM_TYPE = "SRV21";
    $I_PARENT = "";


    $CURSOR = oci_new_cursor($conn);


    $query = "
    SELECT  
    P.SAM_ATTRB_IMG_URL IMAGE_URL,    
    P.SAM_ATTRB_CODE  PRT_CODE  ,P.SAM_ATTRB_DESC  PRT_DESC , P.SAM_ATTRB_DESC_ALT PRT_DESC_ALT  ,P.SAM_AATRB_DESC_BENG PRT_DESC_BENG , P.SAM_ATTRB_SLNO  PRT_SLNO
                    ,A.SAM_ATTRB_CODE  ATR_CODE  ,A.SAM_ATTRB_DESC  ATR_DESC , A.SAM_ATTRB_DESC_ALT ATR_DESC_ALT  ,A.SAM_AATRB_DESC_BENG ATR_DESC_BENG, A.SAM_ATTRB_SLNO  ATR_SLNO
             FROM    SM_SURVEY_ATTRIBUTE_MASTER   A
                    ,SM_SURVEY_ATTRIBUTE_MASTER   P
             WHERE   A.SAM_ATTRB_TYPE  = P.SAM_ATTRB_CODE
               --AND   A.SAM_FORM_NAME   = i_PType
               AND   A.SAM_ATTRB_TYPE  LIKE 'SRV22%'
               AND   A.SAM_ATTRB_TYPE  NOT LIKE 'COV21%'
               AND   A.SAM_ATTRB_TYPE  NOT LIKE 'BNF21%'
               AND   A.SAM_ACTIVE_FLG  = 'A'
            -- ORDER BY P.SAM_ATTRB_SLNO , A.SAM_ATTRB_SLNO
            ORDER BY  A.SAM_ATTRB_CODE asc
    
    
    ";
    $stid = oci_parse($conn, $query);
    $data = "";
    if ($stid) {
        $r = oci_execute($stid);
        if ($r) {
            $data = "";
            $symptoms = [];
            while (($r = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) != false) {
                //     $symptoms[$r["PRT_CODE"]]["header"] = ["PRT_CODE"=>$r["PRT_CODE"],"PRT_DESC"=>$r["PRT_DESC"], "PRT_DESC_ALT"=>$r["PRT_DESC_ALT"]];
                //     $symptoms[$r["PRT_CODE"]]["detail"][] = ["ATR_CODE"=>$r["ATR_CODE"],"ATR_DESC"=>$r["ATR_DESC"],"PRT_SLNO"=> $r["PRT_SLNO"]];
                $symptoms[] = $r;
            }
            $data =  ["status" => 1, "data" => $symptoms, "message" => "success"];
            //$data =  $symptoms;

        } else {
            $e = oci_error($stid); // For oci_execute errors pass the statementhandle
            $data =  ["status" => 1, "data" => [], "message" => $e['message']];
        }
    } else {
        $e = oci_error($conn);  // For oci_parse errors pass the connection handle
        $data =  ["status" => 1, "data" => [], "message" => $e['message']];
    }
    echo json_encode($data);
    oci_free_statement($stid);
    oci_close($conn);
}

function getTrainingMcq($conn, $reqData)
{


    $O_QUE_CUR = oci_new_cursor($conn);
    $O_VED_CUR = oci_new_cursor($conn);
    $query = "begin PKGPH_SM_TRAINING.PRC_POPU_Q_LIST 
	(
		:O_QUE_CUR

        ,:O_Msg 
        ,:O_ErrMsg 
	); 
	end;";
    $stid = oci_parse($conn, $query);
    $data = "";
    if ($stid) {

        oci_bind_by_name($stid, ":O_QUE_CUR", $O_QUE_CUR, -1, OCI_B_CURSOR);
        oci_bind_by_name($stid, ':O_Msg', $O_Msg, 100);
        oci_bind_by_name($stid, ':O_ErrMsg', $O_ErrMsg, 100);
        $r = oci_execute($stid);
        if ($r) {
            if ($O_Msg > 0) {
                $r1 = oci_execute($O_QUE_CUR);
                if ($r1) {
                    while (($r = oci_fetch_array($O_QUE_CUR, OCI_ASSOC + OCI_RETURN_NULLS)) != false) {
                        $currentData[$r["Q_MODULE_ID"]][$r["Q_ID"]]["Q_MODULE_ID"] = $r["Q_MODULE_ID"];
                        $currentData[$r["Q_MODULE_ID"]][$r["Q_ID"]]["Q_ID"] = $r["Q_ID"];
                        $currentData[$r["Q_MODULE_ID"]][$r["Q_ID"]]["Q_DESC"] = $r["Q_ENG_DESC"];
                        $currentData[$r["Q_MODULE_ID"]][$r["Q_ID"]]["Q_ANS"][] = [
                            "ID" => $r["A_ID"],
                            "VALUE" => $r["A_ENG_DESC"],
                            "ANS_FLAG" => $r["CORRECT_Q_ANS"]
                        ];
                    }

                    $newData = [];
                    foreach ($currentData as $key => $value) {
                        foreach ($value as $key => $value1) {
                            $newData[] = $value1;
                        }
                    }

                    echo json_encode($newData);
                } else {
                    $e = oci_error($O_QUE_CUR); // For oci_execute errors pass the statementhandle
                    echo "No Data Found";
                }
            } else {
            }
        } else {
            $e = oci_error($stid); // For oci_execute errors pass the statementhandle
            echo htmlentities($e['message']);
            exit;
        }
    } else {
        $e = oci_error($conn);  // For oci_parse errors pass the connection handle
        echo htmlentities($e['message']);
    }

    oci_free_statement($stid);
    oci_free_statement($O_QUE_CUR);
    oci_close($conn);
}

function getTrainingVideos($conn, $reqData)
{

    $O_VED_CUR = oci_new_cursor($conn);
    $query = "begin PKGPH_SM_TRAINING.PRC_POPU_V_LIST 
	(
		:O_VED_CUR 
        ,:O_Msg 
        ,:O_ErrMsg 
	); 
	end;";
    $stid = oci_parse($conn, $query);

    if ($stid) {


        oci_bind_by_name($stid, ":O_VED_CUR", $O_VED_CUR, -1, OCI_B_CURSOR);
        oci_bind_by_name($stid, ":O_Msg", $O_Msg, 100);
        oci_bind_by_name($stid, ":O_ErrMsg", $O_ErrMsg, 100);
        $r = oci_execute($stid);


        if ($r) {


            //    echo "sdsdsd".$O_Msg;

            if ($O_Msg > 0) {


                $r1 = oci_execute($O_VED_CUR);
                if ($r1) {






                    // M_ID
                    // M_TITLE
                    // M_TITLE_DESC
                    // STV_VID_ID
                    // VID_TITLE
                    // VID_TIT_DESC
                    // STV_VIDEO_PATH
                    // STV_VIDEO_THUM



                    $currentData = [];
                    while (($r = oci_fetch_array($O_VED_CUR, OCI_ASSOC + OCI_RETURN_NULLS)) != false) {
                        $currentData[$r["M_ID"]]["Q_MODULE_ID"] = $r["M_ID"];
                        $currentData[$r["M_ID"]]["Q_MODULE_TITLE"] = $r["M_TITLE"];
                        $currentData[$r["M_ID"]]["Q_MODULE_DESC"] = $r["M_TITLE_DESC"];
                        $currentData[$r["M_ID"]]["Q_MODULE_VIDEOS"][] =
                            [
                                "VIDEO_ID" => $r["STV_VID_ID"],
                                "VIDEO_TITLE" => $r["VID_TITLE"],
                                "VIDEO_DESC" => $r["VID_TIT_DESC"],
                                "VIDEO_THUMBNAIL" => $r["STV_VIDEO_THUM"],
                                "VIDEO_PATH" => $r["STV_VIDEO_PATH"]
                            ];
                    }
                    $newData = [];
                    foreach ($currentData as $key => $value) {
                        $newData[] = $value;
                        # code...
                    }

                    echo json_encode($newData);
                } else {

                    //   echo "sdsdsd";
                    $e = oci_error($O_VED_CUR); // For oci_execute errors pass the statementhandle
                    echo "No Data Found";
                }
            } else {
            }
        } else {


            $e = oci_error($stid); // For oci_execute errors pass the statementhandle
            echo htmlentities($e['message']);
            exit;
        }
    } else {
        $e = oci_error($conn);  // For oci_parse errors pass the connection handle
        echo htmlentities($e['message']);
    }

    oci_free_statement($stid);
    oci_free_statement($O_VED_CUR);
    oci_close($conn);
}

function getNotificationSchedule($conn, $reqData)
{


    $O_NOT_CUR = oci_new_cursor($conn);
    $query = "begin PKGPH_SM_NOTIFICATIONS.PRC_POPU_NOTIFICATIONS 
	(
		:O_NOT_CUR
        ,:O_Msg 
        ,:O_ErrMsg 
	); 
	end;";
    $stid = oci_parse($conn, $query);
    $data = "";
    if ($stid) {

        oci_bind_by_name($stid, ":O_NOT_CUR", $O_NOT_CUR, -1, OCI_B_CURSOR);
        oci_bind_by_name($stid, ':O_Msg', $O_Msg, 100);
        oci_bind_by_name($stid, ':O_ErrMsg', $O_ErrMsg, 100);
        $r = oci_execute($stid);
        if ($r) {


            if ($O_Msg > 0) {
                $r1 = oci_execute($O_NOT_CUR);
                if ($r1) {
                    $myData = [];

                    while ($r = oci_fetch_array($O_NOT_CUR, OCI_ASSOC + OCI_RETURN_LOBS)) {

                        $NOT_FILE = $r["NOTIFICATION_FILE"];
                        $myData["notification_version"] =  $r["NOTIFICATION_VER"];
                        $myData["notification_status"] =  $r["NOTIFICATION_STATUS"];
                        $myData["notification_data"][] =  [
                            "notification_id" => $r["NOTIFICATION_ID"],
                            "notification_time" => $r["NOTIFICATION_TIME"],
                            "notification_frequency" => $r["NOTIFICATION_FREQ"],
                            "notification_title" => $r["NOTIFICATION_TITLE"],
                            "notification_content" => $r["NOTIFICATION_CONTENT"],
                            "notification_file" => $NOT_FILE
                        ];
                    }

                    echo json_encode($myData);
                } else {
                    $e = oci_error($O_NOT_CUR); // For oci_execute errors pass the statementhandle
                    echo "No Data Found";
                }
            } else {
            }
        } else {
            $e = oci_error($stid); // For oci_execute errors pass the statementhandle
            echo htmlentities($e['message']);
            exit;
        }
    } else {
        $e = oci_error($conn);  // For oci_parse errors pass the connection handle
        echo htmlentities($e['message']);
    }

    oci_free_statement($stid);
    oci_free_statement($O_NOT_CUR);
    oci_close($conn);
}

function authLogin($conn, $reqData)
{

    echo json_encode(['status' => 0, 'message' => "Your App is old.Please uninstall the app first", 'user_id' => 0]);
    exit;

    // echo json_encode(['status' => 1, 'message' => "success", "user_id" => "1"]);
    // exit;

    $i_login_type = "SM";
    $i_userId = $reqData['username'];
    $i_password = $reqData['password'];
    $I_IP_ADDR = $_SERVER["REMOTE_ADDR"];
    $I_USER_AGENT = $_SERVER['HTTP_USER_AGENT'];

    $query = "begin PKGPH_TM_TELE_MED.PRC_LOGIN_USER_APP
	(
		:i_login_type,
		:i_userId,
		:i_password,
		:I_IP_ADDR,
		:I_USER_AGENT,
		:o_username,
		:o_userRole,
		:o_userStateCd,
		:o_status,
		:o_msg
	); 
	end;";
    $stid = oci_parse($conn, $query);


    if (!$stid) {
        $e = oci_error($conn);  // For oci_parse errors pass the connection handle
        echo json_encode(['status' => "0", 'message' => "ERROR_PARSE"]);
        exit();
    }

    oci_bind_by_name($stid, ':i_login_type', $i_login_type, 100);
    oci_bind_by_name($stid, ':i_userId', $i_userId, 100);
    oci_bind_by_name($stid, ':i_password', $i_password, 100);
    oci_bind_by_name($stid, ':I_IP_ADDR', $I_IP_ADDR, 100);
    oci_bind_by_name($stid, ':I_USER_AGENT', $I_USER_AGENT, 200);
    oci_bind_by_name($stid, ':o_username', $o_username, 100);
    oci_bind_by_name($stid, ':o_userRole', $o_userRole, 100);
    oci_bind_by_name($stid, ':o_userStateCd', $o_userStateCd, 100);
    oci_bind_by_name($stid, ':o_status', $o_status, 100);
    oci_bind_by_name($stid, ':o_msg', $o_msg, 100);
    $r = oci_execute($stid);
    if (!$r) {
        $e = oci_error($stid); // For oci_execute errors pass the statementhandle
        echo json_encode(['status' => 0, 'message' => $e['message'], 'user_id' => $o_username]);
        exit();
    }

    if ($o_status > 0) {

        // $_SESSION['login_session_token'] = uniqid() . $i_userId;
        // $_SESSION['user_id_app'] = $i_userId;
        // $_SESSION['user_name'] = $o_username;
        // $_SESSION['user_role_cd_app'] = $o_userRole;
        // $_SESSION['user_state_cd_app'] = $o_userStateCd;
        // $time = $_SERVER['REQUEST_TIME'];
        // $_SESSION['LAST_ACTIVITY'] = $time;
        echo json_encode(['status' => 1, 'message' => $o_msg, 'user_id' => $i_userId, 'user_name' => $o_username, 'user_role' => $o_userRole]);
    } else {
        echo json_encode(['status' => 0, 'message' => $o_msg, 'user_id' => 0]);
    }


    oci_free_statement($stid);
    oci_close($conn);
}

function authLoginV1($conn, $reqData)
{
    // params.put("username", luser);
    // params.put("password", lpass);
    // params.put("DEVICE_ID", deviceId);
    // params.put("DEVICE_MODEL", Build.MANUFACTURER + " " + Build.MODEL);
    // params.put("DEVICE_OS", String.valueOf(Build.VERSION.SDK_INT));
    // params.put("APP_VERSION", version);
    // echo json_encode(['status' => 1, 'message' => "success", "user_id" => "1"]);
    // exit;


    $I_USER_ID = $reqData['username'];
    $I_USER_PWD = $reqData['password'];
    $I_DEVICE_ID = $reqData["DEVICE_ID"];
    $I_DEVICE_MODEL = $reqData['DEVICE_MODEL'];
    $I_APP_VERSION = $reqData['APP_VERSION'];
    $I_SDK_VERSION = $reqData['DEVICE_OS'];
    $I_AUTH_TOKEN = $I_USER_ID . '' . $I_USER_PWD . '' . $I_DEVICE_ID . '' . time();
    $I_AUTH_TOKEN = md5($I_AUTH_TOKEN);

    $query = "begin PKGPH_SM_SURVEY_2021.PRC_AUTH_APP_LOGIN
	(
         :I_USER_ID                
        ,:I_USER_PWD               
        ,:I_DEVICE_ID              
        ,:I_DEVICE_MODEL           
        ,:I_APP_VERSION            
        ,:I_SDK_VERSION            
        ,:I_AUTH_TOKEN             
        ,:O_USER_NAME              
        ,:O_USER_ROLE              
        ,:O_STATUS                 
        ,:O_MESSAGE                
	); 
	end;";
    $stid = oci_parse($conn, $query);


    if (!$stid) {
        $e = oci_error($conn);  // For oci_parse errors pass the connection handle
        echo json_encode(['status' => "0", 'message' => "ERROR_PARSE"]);
        exit();
    }


    oci_bind_by_name($stid, ':I_USER_ID', $I_USER_ID, 100);
    oci_bind_by_name($stid, ':I_USER_PWD', $I_USER_PWD, 100);
    oci_bind_by_name($stid, ':I_DEVICE_ID', $I_DEVICE_ID, 100);
    oci_bind_by_name($stid, ':I_DEVICE_MODEL', $I_DEVICE_MODEL, 200);
    oci_bind_by_name($stid, ':I_APP_VERSION', $I_APP_VERSION, 100);
    oci_bind_by_name($stid, ':I_SDK_VERSION', $I_SDK_VERSION, 100);
    oci_bind_by_name($stid, ':I_AUTH_TOKEN', $I_AUTH_TOKEN, 100);
    oci_bind_by_name($stid, ':O_USER_NAME', $O_USER_NAME, 100);
    oci_bind_by_name($stid, ':O_USER_ROLE', $O_USER_ROLE, 100);
    oci_bind_by_name($stid, ':O_STATUS', $O_STATUS, 100);
    oci_bind_by_name($stid, ':O_MESSAGE', $O_MESSAGE, 100);
    $r = oci_execute($stid);
    if (!$r) {
        $e = oci_error($stid); // For oci_execute errors pass the statementhandle
        echo json_encode(['status' => 0, 'message' => "11111" . $e['message'], 'user_id' => $O_USER_NAME]);
        exit();
    }

    if ($O_STATUS > 0) {
        echo json_encode([
            'status' => 1, 'message' => $O_MESSAGE, 'user_id' => $I_USER_ID,
            'user_name' => $O_USER_NAME,
            'user_role' => $O_USER_ROLE,
            'auth_token' => $I_AUTH_TOKEN
        ]);
    } else {
        echo json_encode(['status' => 0, 'message' => $O_MESSAGE, 'user_id' => 0]);
    }


    oci_free_statement($stid);
    oci_close($conn);
}

function authLoginV2($conn, $reqData)
{
    // params.put("username", luser);
    // params.put("password", lpass);
    // params.put("DEVICE_ID", deviceId);
    // params.put("DEVICE_MODEL", Build.MANUFACTURER + " " + Build.MODEL);
    // params.put("DEVICE_OS", String.valueOf(Build.VERSION.SDK_INT));
    // params.put("APP_VERSION", version);
    // echo json_encode(['status' => 1, 'message' => "success", "user_id" => "1"]);
    // exit;


    $I_USER_ID = $reqData['username'];
    $I_USER_PWD = $reqData['password'];
    $I_DEVICE_ID = $reqData["DEVICE_ID"];
    $I_DEVICE_MODEL = $reqData['DEVICE_MODEL'];
    $I_APP_VERSION = $reqData['APP_VERSION'];
    $I_SDK_VERSION = $reqData['DEVICE_OS'];
    $I_AUTH_TOKEN = $I_USER_ID . '' . $I_USER_PWD . '' . $I_DEVICE_ID . '' . time();
    $I_FCM_TOKEN  = $reqData['FCM_TOKEN'];
    $I_AUTH_TOKEN = md5($I_AUTH_TOKEN);

    $query = "begin PKGPH_SM_SURVEY_2021.PRC_AUTH_APP_LOGIN_V2
	(
         :I_USER_ID                
        ,:I_USER_PWD               
        ,:I_DEVICE_ID              
        ,:I_DEVICE_MODEL           
        ,:I_APP_VERSION            
        ,:I_SDK_VERSION            
        ,:I_AUTH_TOKEN             
        ,:I_FCM_TOKEN             
        ,:O_USER_NAME              
        ,:O_USER_ROLE              
        ,:O_STATUS                 
        ,:O_MESSAGE                
	); 
	end;";
    $stid = oci_parse($conn, $query);


    if (!$stid) {
        $e = oci_error($conn);  // For oci_parse errors pass the connection handle
        echo json_encode(['status' => "0", 'message' => "ERROR_PARSE"]);
        exit();
    }


    oci_bind_by_name($stid, ':I_USER_ID', $I_USER_ID, 100);
    oci_bind_by_name($stid, ':I_USER_PWD', $I_USER_PWD, 100);
    oci_bind_by_name($stid, ':I_DEVICE_ID', $I_DEVICE_ID, 100);
    oci_bind_by_name($stid, ':I_DEVICE_MODEL', $I_DEVICE_MODEL, 200);
    oci_bind_by_name($stid, ':I_APP_VERSION', $I_APP_VERSION, 100);
    oci_bind_by_name($stid, ':I_SDK_VERSION', $I_SDK_VERSION, 100);
    oci_bind_by_name($stid, ':I_AUTH_TOKEN', $I_AUTH_TOKEN, 100);
    oci_bind_by_name($stid, ':I_FCM_TOKEN', $I_FCM_TOKEN, 500);
    oci_bind_by_name($stid, ':O_USER_NAME', $O_USER_NAME, 100);
    oci_bind_by_name($stid, ':O_USER_ROLE', $O_USER_ROLE, 100);
    oci_bind_by_name($stid, ':O_STATUS', $O_STATUS, 100);
    oci_bind_by_name($stid, ':O_MESSAGE', $O_MESSAGE, 100);
    $r = oci_execute($stid);
    if (!$r) {
        $e = oci_error($stid); // For oci_execute errors pass the statementhandle
        echo json_encode(['status' => 0, 'message' => "11111" . $e['message'], 'user_id' => $O_USER_NAME]);
        exit();
    }

    if ($O_STATUS > 0) {
        echo json_encode([
            'status' => 1, 'message' => $O_MESSAGE, 'user_id' => $I_USER_ID,
            'user_name' => $O_USER_NAME,
            'user_role' => $O_USER_ROLE,
            'auth_token' => $I_AUTH_TOKEN
        ]);
    } else {
        echo json_encode(['status' => 0, 'message' => $O_MESSAGE, 'user_id' => 0]);
    }


    oci_free_statement($stid);
    oci_close($conn);
}

function authLoginV3($conn, $reqData)
{
    // params.put("username", luser);
    // params.put("password", lpass);
    // params.put("DEVICE_ID", deviceId);
    // params.put("DEVICE_MODEL", Build.MANUFACTURER + " " + Build.MODEL);
    // params.put("DEVICE_OS", String.valueOf(Build.VERSION.SDK_INT));
    // params.put("APP_VERSION", version);
    // echo json_encode(['status' => 1, 'message' => "success", "user_id" => "1"]);
    // exit;


    $I_USER_ID = $reqData['username'];
    $I_USER_PWD = $reqData['password'];
    $I_DEVICE_ID = $reqData["device_id"];
    $I_DEVICE_MODEL = $reqData['device_model'];
    $I_APP_VERSION = $reqData['app_version'];
    $I_SDK_VERSION = $reqData['DEVICE_OS'];
    $I_AUTH_TOKEN = $I_USER_ID . '' . $I_USER_PWD . '' . $I_DEVICE_ID . '' . time();
    $I_FCM_TOKEN  = $reqData['FCM_TOKEN'];
    $I_AUTH_TOKEN = md5($I_AUTH_TOKEN);

    $query = "begin PKGPH_TEST_KKP.PRC_SM_APP_USER_LOGIN
	(
         :I_USER_ID                
        ,:I_USER_PWD               
        ,:I_DEVICE_ID              
        ,:I_DEVICE_MODEL           
        ,:I_APP_VERSION            
        ,:I_SDK_VERSION            
        ,:I_AUTH_TOKEN             
        ,:I_FCM_TOKEN             
        ,:O_USER_NAME              
        ,:O_USER_ROLE              
        ,:O_USER_STATE_CD              
        ,:O_STATUS                 
        ,:O_MESSAGE                
	); 
	end;";
    $stid = oci_parse($conn, $query);


    if (!$stid) {
        $e = oci_error($conn);  // For oci_parse errors pass the connection handle
        echo json_encode(['status' => "0", 'message' => "ERROR_PARSE"]);
        exit();
    }


    oci_bind_by_name($stid, ':I_USER_ID', $I_USER_ID, 100);
    oci_bind_by_name($stid, ':I_USER_PWD', $I_USER_PWD, 100);
    oci_bind_by_name($stid, ':I_DEVICE_ID', $I_DEVICE_ID, 100);
    oci_bind_by_name($stid, ':I_DEVICE_MODEL', $I_DEVICE_MODEL, 200);
    oci_bind_by_name($stid, ':I_APP_VERSION', $I_APP_VERSION, 100);
    oci_bind_by_name($stid, ':I_SDK_VERSION', $I_SDK_VERSION, 100);
    oci_bind_by_name($stid, ':I_AUTH_TOKEN', $I_AUTH_TOKEN, 100);
    oci_bind_by_name($stid, ':I_FCM_TOKEN', $I_FCM_TOKEN, 500);
    oci_bind_by_name($stid, ':O_USER_NAME', $O_USER_NAME, 100);
    oci_bind_by_name($stid, ':O_USER_ROLE', $O_USER_ROLE, 100);
    oci_bind_by_name($stid, ':O_USER_STATE_CD', $O_USER_STATE_CD, 100);
    oci_bind_by_name($stid, ':O_STATUS', $O_STATUS, 100);
    oci_bind_by_name($stid, ':O_MESSAGE', $O_MESSAGE, 100);
    $r = oci_execute($stid);
    if (!$r) {
        $e = oci_error($stid); // For oci_execute errors pass the statementhandle
        echo json_encode(['status' => 0, 'message' => "11111" . $e['message'], 'user_id' => $O_USER_NAME]);
        exit();
    }

    if ($O_STATUS > 0) {
        echo json_encode([
            'status' => 1,
            'message' => $O_MESSAGE,
            'user_id' => $I_USER_ID,
            'user_name' => $O_USER_NAME,
            'user_role' => $O_USER_ROLE,
            'auth_token' => $I_AUTH_TOKEN,
            'user_state_cd' => $O_USER_STATE_CD
        ]);
    } else {
        echo json_encode(['status' => 0, 'message' => $O_MESSAGE, 'user_id' => 0]);
    }


    oci_free_statement($stid);
    oci_close($conn);
}

// function logoutUser($conn, $reqData)
// {
//     // params.put("username", luser);
//     // params.put("password", lpass);
//     // params.put("DEVICE_ID", deviceId);
//     // params.put("DEVICE_MODEL", Build.MANUFACTURER + " " + Build.MODEL);
//     // params.put("DEVICE_OS", String.valueOf(Build.VERSION.SDK_INT));
//     // params.put("APP_VERSION", version);
//     // echo json_encode(['status' => 1, 'message' => "success", "user_id" => "1"]);
//     // exit;


//     $I_AUTH_TOKEN = $reqData['auth_token'];
//     $query = "begin PKGPH_SM_SURVEY_2021.PRC_AUTH_APP_LOGOUT
// 	(
//          :I_AUTH_TOKEN
//         ,:O_STATUS                 
//         ,:O_MESSAGE                
// 	); 
// 	end;";
//     $stid = oci_parse($conn, $query);


//     if (!$stid) {
//         $e = oci_error($conn);  // For oci_parse errors pass the connection handle
//         echo json_encode(['status' => "0", 'message' => "ERROR_PARSE"]);
//         exit();
//     }


//     oci_bind_by_name($stid, ':I_AUTH_TOKEN', $I_AUTH_TOKEN, 100);
//     oci_bind_by_name($stid, ':O_STATUS', $O_STATUS, 100);
//     oci_bind_by_name($stid, ':O_MESSAGE', $O_MESSAGE, 100);
//     $r = oci_execute($stid);
//     if (!$r) {
//         $e = oci_error($stid); // For oci_execute errors pass the statementhandle
//         echo json_encode(['status' => 0, 'message' => "11111" . $e['message']]);
//         exit();
//     }
//     if ($O_STATUS > 0) {
//         echo json_encode(['status' => 1, 'message' => $O_MESSAGE]);
//     } else {
//         echo json_encode(['status' => 0, 'message' => $O_MESSAGE, 'user_id' => 0]);
//     }


//     oci_free_statement($stid);
//     oci_close($conn);
// }

# [5376][19-02-2024 10:50 AM][UPDATE]: PACKAGE AND PROCEDURE NAME CHANGED
function logoutUser($conn, $reqData)
{
    // params.put("username", luser);
    // params.put("password", lpass);
    // params.put("DEVICE_ID", deviceId);
    // params.put("DEVICE_MODEL", Build.MANUFACTURER + " " + Build.MODEL);
    // params.put("DEVICE_OS", String.valueOf(Build.VERSION.SDK_INT));
    // params.put("APP_VERSION", version);
    // echo json_encode(['status' => 1, 'message' => "success", "user_id" => "1"]);
    // exit;


    $I_AUTH_TOKEN = $reqData['auth_token'];
    $query = "begin PKGPH_SM_APP_AUTH.PRC_USER_LOGOUT
	(
         :I_AUTH_TOKEN
        ,:O_STATUS                 
        ,:O_MESSAGE                
	); 
	end;";
    $stid = oci_parse($conn, $query);


    if (!$stid) {
        $e = oci_error($conn);  // For oci_parse errors pass the connection handle
        echo json_encode(['status' => "0", 'message' => "ERROR_PARSE"]);
        exit();
    }


    oci_bind_by_name($stid, ':I_AUTH_TOKEN', $I_AUTH_TOKEN, 100);
    oci_bind_by_name($stid, ':O_STATUS', $O_STATUS, 100);
    oci_bind_by_name($stid, ':O_MESSAGE', $O_MESSAGE, 100);
    $r = oci_execute($stid);
    if (!$r) {
        $e = oci_error($stid); // For oci_execute errors pass the statementhandle
        echo json_encode(['status' => 0, 'message' => "11111" . $e['message']]);
        exit();
    }
    if ($O_STATUS > 0) {
        echo json_encode(['status' => 1, 'message' => $O_MESSAGE]);
    } else {
        echo json_encode(['status' => 0, 'message' => $O_MESSAGE, 'user_id' => 0]);
    }


    oci_free_statement($stid);
    oci_close($conn);
}

function createFamily($conn, $reqData)
{



    $i_SSFM_ID               =  $reqData["family-id"];
    $i_SSFM_HEAD_NAME        =  $reqData["family-head-name"];
    $i_SSFM_CONTACT_NO       =  $reqData["contact-no"];
    $i_SSFM_HOUSE_NO         =  $reqData["house-no"];
    $i_SSFM_ADDR             =  $reqData["address"];
    $i_SSFM_GAON_PNCHYT      =  $reqData["gaon-panchayat-code"];
    $i_SSFM_BLOCK_CODE       =  $reqData["block-code"];
    $i_SSFM_CITY_CODE        =  $reqData["city-code"];
    $i_SSFM_DIST_CODE        =  $reqData["dist-code"];
    $i_SSFM_STATE_CODE       =  $reqData["state-code"];
    $i_SSFM_PIN              =  $reqData["pin-code"];
    $i_UserId                =  $reqData["user-id"];



    $query = "begin PKGPH_TM_TELE_MED_KKP.PRC_I_FAMILY_MASTER
	(
         :i_SSFM_ID           
        ,:i_SSFM_HEAD_NAME    
        ,:i_SSFM_CONTACT_NO   
        ,:i_SSFM_HOUSE_NO     
        ,:i_SSFM_ADDR         
        ,:i_SSFM_GAON_PNCHYT  
        ,:i_SSFM_BLOCK_CODE   
        ,:i_SSFM_CITY_CODE    
        ,:i_SSFM_DIST_CODE    
        ,:i_SSFM_STATE_CODE   
        ,:i_SSFM_PIN          
        ,:i_UserId            
        ,:o_status               
        ,:o_msg            
	); 
	end;";
    $stid = oci_parse($conn, $query);


    if (!$stid) {
        $e = oci_error($conn);  // For oci_parse errors pass the connection handle
        echo json_encode(['status' => "0", 'message' => "ERROR_PARSE"]);
        exit();
    }

    oci_bind_by_name($stid, ':i_SSFM_ID', $i_SSFM_ID, 100);
    oci_bind_by_name($stid, ':i_SSFM_HEAD_NAME', $i_SSFM_HEAD_NAME, 100);
    oci_bind_by_name($stid, ':i_SSFM_CONTACT_NO', $i_SSFM_CONTACT_NO, 100);
    oci_bind_by_name($stid, ':i_SSFM_HOUSE_NO', $i_SSFM_HOUSE_NO, 100);
    oci_bind_by_name($stid, ':i_SSFM_ADDR', $i_SSFM_ADDR, 200);
    oci_bind_by_name($stid, ':i_SSFM_GAON_PNCHYT', $i_SSFM_GAON_PNCHYT, 100);
    oci_bind_by_name($stid, ':i_SSFM_BLOCK_CODE', $i_SSFM_BLOCK_CODE, 100);
    oci_bind_by_name($stid, ':i_SSFM_CITY_CODE', $i_SSFM_CITY_CODE, 100);
    oci_bind_by_name($stid, ':i_SSFM_DIST_CODE', $i_SSFM_DIST_CODE, 100);
    oci_bind_by_name($stid, ':i_SSFM_STATE_CODE', $i_SSFM_STATE_CODE, 100);
    oci_bind_by_name($stid, ':i_SSFM_PIN', $i_SSFM_PIN, 100);
    oci_bind_by_name($stid, ':i_UserId', $i_UserId, 100);
    oci_bind_by_name($stid, ':o_status', $o_status, 100);
    oci_bind_by_name($stid, ':o_msg', $o_msg, 100);
    $r = oci_execute($stid, OCI_NO_AUTO_COMMIT);
    if (!$r) {
        $e = oci_error($stid); // For oci_execute errors pass the statementhandle
        echo json_encode(['status' => 0, 'message' => $e['message']]);
        exit();
    }

    if ($o_status > 0) {
        $r = oci_commit($conn);
        echo json_encode(['status' => 1, 'message' => $o_msg]);
    } else {
        oci_rollback($conn);
        echo json_encode(['status' => 0, 'message' => $o_msg]);
    }


    oci_free_statement($stid);
    oci_close($conn);
}

function getFamily($conn, $reqData)
{

    $resultData = [];
    $i_SSFM_ID = $reqData["family-id"];
    $curs = oci_new_cursor($conn);
    $query = "begin PKGPH_TM_TELE_MED_KKP.PRC_POPU_FAMILY_MASTER 
	(
		:i_SSFM_ID,
		:CURSOR 
	); 
	end;";
    $stid = oci_parse($conn, $query);
    $data = "";
    if ($stid) {
        oci_bind_by_name($stid, ':i_SSFM_ID', $i_SSFM_ID, 100);
        oci_bind_by_name($stid, ":CURSOR", $curs, -1, OCI_B_CURSOR);
        $r = oci_execute($stid);
        if ($r) {
            $r1 = oci_execute($curs);
            if ($r1) {
                while (($r = oci_fetch_array($curs, OCI_ASSOC + OCI_RETURN_NULLS)) != false) {
                    $resultData[] = $r;
                }
                echo json_encode($resultData);
            } else {
                $e = oci_error($curs); // For oci_execute errors pass the statementhandle
                echo "No Data Found";
            }
        } else {
            $e = oci_error($stid); // For oci_execute errors pass the statementhandle
            echo htmlentities($e['message']);
            exit;
        }
    } else {
        $e = oci_error($conn);  // For oci_parse errors pass the connection handle
        echo htmlentities($e['message']);
    }

    oci_free_statement($stid);
    oci_free_statement($curs);
    oci_close($conn);
}

function getCommonData($conn, $reqData)
{

    $resultData = [];
    $req_type =   $reqData["req_type"];
    $i_PType = "";
    if ($req_type == "get-state-list") {
        $i_PType = "STATE";
        $i_Parent = "INDIA";
        $resultData[] = ["CODE" => 0, "VALUE" => "-Select State-"];
    }

    if ($req_type == "get-district-list") {
        $i_PType = "ALL_DIST";
        $i_Parent = "";
        //   echo json_encode([["id" => 0, "value" => "-Select District-"], ["id" => 1, "value" => "Kamrup"], ["id" => 2, "value" => "Kamrup Metro"]]);
        $resultData[] = ["CODE" => 0, "VALUE" => "-Select District-", "STATE_CD" => "0"];
    }






    $curs = oci_new_cursor($conn);
    $query = "begin PKGPH_SM_SURVEY_2021.PRC_POPU_PARAM 
	(
		:i_PType,
        :i_Parent,
		:CURSOR 
	); 
	end;";
    $stid = oci_parse($conn, $query);
    $data = "";
    if ($stid) {
        oci_bind_by_name($stid, ':i_PType', $i_PType, 100);
        oci_bind_by_name($stid, ':i_Parent', $i_Parent, 100);
        oci_bind_by_name($stid, ":CURSOR", $curs, -1, OCI_B_CURSOR);
        $r = oci_execute($stid);
        if ($r) {
            $r1 = oci_execute($curs);
            if ($r1) {


                while (($r = oci_fetch_array($curs, OCI_ASSOC + OCI_RETURN_NULLS)) != false) {
                    $resultData[] = $r;
                }
                echo json_encode($resultData);
            } else {
                $e = oci_error($curs); // For oci_execute errors pass the statementhandle
                echo "No Data Found";
            }
        } else {
            $e = oci_error($stid); // For oci_execute errors pass the statementhandle
            echo htmlentities($e['message']);
            exit;
        }
    } else {
        $e = oci_error($conn);  // For oci_parse errors pass the connection handle
        echo htmlentities($e['message']);
    }

    oci_free_statement($stid);
    oci_free_statement($curs);
    oci_close($conn);
}

function getNewsFeed($conn, $reqData)
{

    $data0 =
        [
            "title" => "GNRC Hospitals | Dr. Nomal Chandra Borah speaks on COVID-19",
            "author"  => "Dr. Nomal Ch. Borah",
            "date"  => "20-10-2022 10:10 AM",
            "content_desc" =>
            "We can protect ourselves and others from the pandemic of Novel Coronavirus by following simple hygiene steps. Its high time we consider the matter very seriously as the total number of Novel Coronavirus cases in India rose to 166 today.",
            "video_url" => "https://gnrctelehealth.com/telehealth_api/videos/gnrc.mp4",
            "thumbnail_url" => "https://gnrctelehealth.com/telehealth_api/thumbnail/cmd_001.jpg",
            "content_type" => "video"
        ];


    $data1 =
        [
            "title" => "GNRC Hospitals | Swasthya Mitra Lecture Series - Episode 32 | Dr. Nomal Chandra Borah",
            "author"  => "Dr. Nomal Ch. Borah",
            "date"  => "20-10-2022 10:10 AM",
            "content_desc" => "Swasthya Mitra Lecture Series is an attempt to educate and sensitize the Community Health Workers working as Swasthya Mitras under Affordable Health Mission, A GNRC initiative. Moreover, the programme aims to educate common people as well. This series of lectures covers preventive measures and awareness of various medical emergencies like Stroke, Epilepsy, Heart Attack etc by Dr. Nomal Chandra Borah, Founder- Affordable Health Mission & GNRC Hospitals.",
            "video_url" => "https://gnrctelehealth.com/telehealth_api/videos/gnrc_2.mp4",
            "thumbnail_url" => "https://gnrchospitals.com/files/16511329606267e02d37fe8b1ab26b12.jpg",
            "content_type" => "video"
        ];






    $resultData[] = $data0;
    $resultData[] = $data1;
    echo json_encode($resultData);
}

function getWalletTransactions($conn, $reqData)
{

    $resultData = [];
    $i_req_type = $reqData["filter-by"];
    $i_req_for = $reqData["user-id"];
    $i_from_dt = "1";
    $i_to_dt = "1";
    $curs = oci_new_cursor($conn);
    $query = "begin PKGPH_SM_WALLET.PRC_POPU_WALLET_DET 
	(
             :i_req_type,   
             :i_req_for,
             :i_from_dt,
             :i_to_dt,
             :cS_Data        
	); 
	end;";
    $stid = oci_parse($conn, $query);
    $data = "";
    if ($stid) {
        oci_bind_by_name($stid, ':i_req_type', $i_req_type, 100);
        oci_bind_by_name($stid, ':i_req_for', $i_req_for, 100);
        oci_bind_by_name($stid, ':i_from_dt', $i_from_dt, 100);
        oci_bind_by_name($stid, ':i_to_dt', $i_to_dt, 100);
        oci_bind_by_name($stid, ":cS_Data", $curs, -1, OCI_B_CURSOR);
        $r = oci_execute($stid);
        if ($r) {
            $r1 = oci_execute($curs);
            if ($r1) {
                while (($r = oci_fetch_array($curs, OCI_ASSOC + OCI_RETURN_NULLS)) != false) {
                    $resultData[] = $r;
                }
                echo json_encode($resultData);
            } else {
                $e = oci_error($curs); // For oci_execute errors pass the statementhandle
                // echo "No Data Found";
            }
        } else {
            $e = oci_error($stid); // For oci_execute errors pass the statementhandle
            // echo htmlentities($e['message']);
            exit;
        }
    } else {
        $e = oci_error($conn);  // For oci_parse errors pass the connection handle
        echo htmlentities($e['message']);
    }

    oci_free_statement($stid);
    oci_free_statement($curs);
    oci_close($conn);
}

function setReedemRequest($conn, $reqData)
{




    $i_Trans_Amount        =  $reqData["reedem-amount"];
    $i_Remarks       =         $reqData["remarks"];
    $i_UserId               =  $reqData["user-id"];



    $query = "begin PKGPH_SM_WALLET.PRC_I_REDEEM_REQUEST
	(
        :i_Trans_Amount    
        ,:i_Remarks           
        ,:i_UserId            
        ,:o_status               
        ,:o_msg            
	); 
	end;";
    $stid = oci_parse($conn, $query);


    if (!$stid) {
        $e = oci_error($conn);  // For oci_parse errors pass the connection handle
        echo json_encode(['status' => "0", 'message' => "ERROR_PARSE"]);
        exit();
    }

    oci_bind_by_name($stid, ':i_Trans_Amount', $i_Trans_Amount, 100);
    oci_bind_by_name($stid, ':i_Remarks', $i_Remarks, 100);
    oci_bind_by_name($stid, ':i_UserId', $i_UserId, 100);
    oci_bind_by_name($stid, ':o_status', $o_status, 100);
    oci_bind_by_name($stid, ':o_msg', $o_msg, 100);
    $r = oci_execute($stid, OCI_NO_AUTO_COMMIT);
    if (!$r) {
        $e = oci_error($stid); // For oci_execute errors pass the statementhandle
        echo json_encode(['status' => 0, 'message' => $e['message']]);
        exit();
    }

    if ($o_status > 0) {
        $r = oci_commit($conn);
        echo json_encode(['status' => 1, 'message' => $o_msg]);
    } else {
        oci_rollback($conn);
        echo json_encode(['status' => 0, 'message' => $o_msg]);
    }


    oci_free_statement($stid);
    oci_close($conn);
}

function getWalletBalance($conn, $reqData)
{
    $returnData = [];
    $i_UserId = $reqData["user-id"];
    $query = "begin PKGPH_SM_WALLET.PRC_GET_WALLET_BALANCE 
	(
             :i_UserId,
             :o_earning,
             :o_deduction,
             :o_Redeem,        
             :o_balance,
             :o_bank_acc_no,
             :o_bank_name,
             :o_bank_ifsc,
             :o_Msg,
             :o_RetMsg        
	); 
	end;";
    $stid = oci_parse($conn, $query);
    $data = "";
    if ($stid) {
        oci_bind_by_name($stid, ':i_UserId', $i_UserId, 100);
        oci_bind_by_name($stid, ':o_earning', $o_earning, 100);
        oci_bind_by_name($stid, ':o_deduction', $o_deduction, 100);
        oci_bind_by_name($stid, ':o_Redeem', $o_Redeem, 100);
        oci_bind_by_name($stid, ':o_balance', $o_balance, 100);
        oci_bind_by_name($stid, ':o_bank_acc_no', $o_bank_acc_no, 100);
        oci_bind_by_name($stid, ':o_bank_name', $o_bank_name, 100);
        oci_bind_by_name($stid, ':o_bank_ifsc', $o_bank_ifsc, 100);
        oci_bind_by_name($stid, ':o_Msg', $o_Msg, 100);
        oci_bind_by_name($stid, ':o_RetMsg', $o_RetMsg, 100);
        $r = oci_execute($stid);
        if ($r) {
            $returnData = [
                "status" => $o_Msg, "message" => $o_RetMsg,
                "wallet-earning" => $o_earning,
                "wallet-deduction" => $o_deduction,
                "wallet-balance" => $o_balance,
                "wallet-redeemed" => $o_Redeem,
                "bank_acc_no" => $o_bank_acc_no,
                "bank_name" => $o_bank_name,
                "bank_ifsc" => $o_bank_ifsc
            ];
        } else {
            $e = oci_error($stid); // For oci_execute errors pass the statementhandle
            $returnData = ["status" => 0, "message" => $e['message']];
        }
    } else {
        $e = oci_error($conn);  // For oci_parse errors pass the connection handle
        $returnData = ["status" => 0, "message" => $e['message']];
    }

    echo json_encode($returnData);
    oci_free_statement($stid);
    oci_close($conn);
}

function getReedemRequests($conn, $reqData)
{

    $resultData = [];
    $i_req_type = $reqData["filter-by"];


    $i_req_for = $reqData["user-id"];
    $curs = oci_new_cursor($conn);
    $query = "begin PKGPH_SM_WALLET.PRC_POPU_REDEEM_REQUEST 
	(
        :i_req_type    
        ,:i_req_for
        ,:cS_Data        
	); 
	end;";
    $stid = oci_parse($conn, $query);
    $data = "";
    if ($stid) {
        oci_bind_by_name($stid, ':i_req_type', $i_req_type, 100);
        oci_bind_by_name($stid, ':i_req_for', $i_req_for, 100);
        oci_bind_by_name($stid, ":cS_Data", $curs, -1, OCI_B_CURSOR);
        $r = oci_execute($stid);
        if ($r) {
            $r1 = oci_execute($curs);
            if ($r1) {
                while (($r = oci_fetch_array($curs, OCI_ASSOC + OCI_RETURN_NULLS)) != false) {
                    $resultData[] = $r;
                }
                echo json_encode($resultData);
            } else {
                $e = oci_error($curs); // For oci_execute errors pass the statementhandle
                // echo "No Data Found";
            }
        } else {
            $e = oci_error($stid); // For oci_execute errors pass the statementhandle
            // echo htmlentities($e['message']);
            exit;
        }
    } else {
        $e = oci_error($conn);  // For oci_parse errors pass the connection handle
        echo htmlentities($e['message']);
    }

    oci_free_statement($stid);
    oci_free_statement($curs);
    oci_close($conn);
}

function getSurveyData($conn, $reqData)
{




    $surveyData = [];

    $i_txn_no = $reqData["search_text"];
    $resultHeadData = [];
    $resultMemberData = [];
    $resultSymptomsData = [];
    $cS_HeadData = oci_new_cursor($conn);
    $cS_MemberData = oci_new_cursor($conn);
    $cS_SymptomsData = oci_new_cursor($conn);
    $query = "begin PKGPH_SM_SURVEY_2021.PRC_POPU_SURVEY_DATA_2023 
	(
		:i_txn_no,
		:cS_HeadData,
        :cS_MemberData,
        :cS_SymptomsData 
	); 
	end;";
    $stid = oci_parse($conn, $query);
    $data = "";
    if ($stid) {
        oci_bind_by_name($stid, ':i_txn_no', $i_txn_no, 100);
        oci_bind_by_name($stid, ":cS_HeadData", $cS_HeadData, -1, OCI_B_CURSOR);
        oci_bind_by_name($stid, ":cS_MemberData", $cS_MemberData, -1, OCI_B_CURSOR);
        oci_bind_by_name($stid, ":cS_SymptomsData", $cS_SymptomsData, -1, OCI_B_CURSOR);
        $r = oci_execute($stid);
        if ($r) {
            $r1 = oci_execute($cS_HeadData);
            if ($r1) {
                while (($r = oci_fetch_array($cS_HeadData, OCI_ASSOC + OCI_RETURN_NULLS)) != false) {
                    $resultHeadData[] = $r;
                }
            }
            $r1 = oci_execute($cS_MemberData);
            if ($r1) {
                while (($r = oci_fetch_array($cS_MemberData, OCI_ASSOC + OCI_RETURN_NULLS)) != false) {
                    $resultMemberData[] = $r;
                }
            }
            $r1 = oci_execute($cS_SymptomsData);
            if ($r1) {
                while (($r = oci_fetch_array($cS_SymptomsData, OCI_ASSOC + OCI_RETURN_NULLS)) != false) {
                    $resultSymptomsData[] = $r;
                }
            }
            $symptoms = [];
            $symptoms1 = [];

            foreach ($resultSymptomsData as $v) {

                $symptoms1[$v["MEMBERSURVEY_ID"]]["SYMPTOMS"][] =
                    [
                        'GROUP_SURVEYID' => $v["GROUP_SURVEYID"],
                        'ATR_CODE' => $v["ATR_CODE"],
                        'MEMBER_ID' => $v["MEMBER_ID"],
                        'SSR_FAMILY_ID' => $v["SSR_FAMILY_ID"],
                        'MEMBER_NAME' => $v["MEMBER_NAME"],
                        'PRT_DESC' => $v["PRT_DESC"],
                        'ATR_DESC' => $v["ATR_DESC"],
                        'CHECKSTATE' => $v["CHECKSTATE"],
                        'MEMBERSURVEY_ID' => $v["MEMBERSURVEY_ID"],
                        'SYMPTOM_TIMESTAMP' => $v["SYMPTOM_TIMESTAMP"],
                        'SYMPTOM_USER_ID' => $v["SYMPTOM_USER_ID"]

                    ];
            }





            foreach ($resultSymptomsData as $v) {
                $symptoms[$v["MEMBERSURVEY_ID"]]["SYMPTOMS_DATA"] =
                    [
                        "SSR_FAMILY_ID" => $v["SSR_FAMILY_ID"],
                        "GROUP_SURVEYID" => $v["GROUP_SURVEYID"],
                        "MEMBERSURVEY_ID" => $v["MEMBERSURVEY_ID"],
                        "MEMBER_ID" => $v["MEMBER_ID"],
                        "MEMBER_NAME" => $v["MEMBER_NAME"],
                        "SMOKING" => $v["SMOKING"],
                        "ALCOHOL" => $v["ALCOHOL"],
                        "LATITUDE" => $v["LATITUDE"],
                        "LONGITUDE" => $v["LONGITUDE"],
                        "BP_SYS" => $v["BP_SYS"],
                        "BP_DIA" => $v["BP_DIA"],
                        "GLUCOSE_TYPE" => $v["GLUCOSE_TYPE"],
                        "GLUCOSE_VALUE" => $v["GLUCOSE_VALUE"],
                        "ATAL_AMRIT" => $v["ATAL_AMRIT"],
                        "AYUSHMAN_BHARAT" => $v["AYUSHMAN_BHARAT"],
                        "TELEMEDICINE_BOOKED" => $v["TELEMEDICINE_BOOKED"],
                        "OPD_BOOKED" => $v["OPD_BOOKED"],
                        "AMBULANCE_BOOKED" => $v["AMBULANCE_BOOKED"],
                        "MEMBER_TIMESTAMP" => $v["MEMBER_TIMESTAMP"],
                        "MEMBER_USER_ID" => $v["MEMBER_USER_ID"],
                        "SYMPTOMS" => $symptoms1[$v["MEMBERSURVEY_ID"]]["SYMPTOMS"]

                    ];
            }


            foreach ($symptoms as $v) {
                $surveyData["SYMPTOMS_DATA"][] = $v["SYMPTOMS_DATA"];
            }

            $surveyData["MEMBER_DATA"] = $resultMemberData;
            $surveyData["HEAD_DATA"] = $resultHeadData;
        } else {
            $e = oci_error($stid); // For oci_execute errors pass the statementhandle
            echo htmlentities($e['message']);
            exit;
        }
    } else {
        $e = oci_error($conn);  // For oci_parse errors pass the connection handle
        echo htmlentities($e['message']);
    }



    oci_free_statement($stid);
    oci_free_statement($cS_HeadData);
    oci_free_statement($cS_MemberData);
    oci_free_statement($cS_SymptomsData);
    oci_close($conn);

    echo $str = json_encode($surveyData);



    // $str = json_encode($surveyData);

    // $y = json_decode($str , true);
    /// echo json_encode($surveyData);





}

function unlinkConsentFile($i_ConsentFileName_arr)
{

    foreach ($i_ConsentFileName_arr as $key => $value) {
        if (file_exists("consent_files/" . $value)) {
            unlink("consent_files/" . $value);
        }
    }
}

function getDistanceBetweenSurveys($conn, $i_survey_date, $o_latitude2, $o_longitude2, $i_user_id)
{
    $calculatedDistance = 0;

    $query = "begin PKGPH_SM_SURVEY_2021.PRC_POPU_PREV_DIST_COORDI 
	(
        :i_survey_date    ,
        :i_user_id        ,
        :o_latitude       ,
        :o_longitude      ,
        :o_Msg            ,
        :o_RetMsg         
	); 
	end;";
    $stid = oci_parse($conn, $query);
    $data = "";
    if ($stid) {


        oci_bind_by_name($stid, ':i_survey_date', $i_survey_date, 100);
        oci_bind_by_name($stid, ':i_user_id', $i_user_id, 100);
        oci_bind_by_name($stid, ':o_latitude', $o_latitude1, 100);
        oci_bind_by_name($stid, ':o_longitude', $o_longitude1, 100);
        oci_bind_by_name($stid, ':o_Msg', $o_Msg, 100);
        oci_bind_by_name($stid, ':o_RetMsg', $o_RetMsg, 100);
        $r = oci_execute($stid);
        if ($r) {
            if ($o_Msg > 0) {
                $calculatedDistance = calculate_distance($o_latitude1, $o_longitude1, $o_latitude2, $o_longitude2, "K");
                if (is_nan($calculatedDistance)) {
                    $calculatedDistance = 0;
                }
                if ($o_latitude1 == 0 || $o_latitude1 == "") {
                    $calculatedDistance = 0;
                }
            } else {
                // return 0;
            }
        } else {
            $e = oci_error($stid); // For oci_execute errors pass the statementhandle
            echo htmlentities($e['message']);
            exit;
        }
    } else {
        $e = oci_error($conn);  // For oci_parse errors pass the connection handle
        echo htmlentities($e['message']);
    }

    oci_free_statement($stid);
    oci_close($conn);

    return $calculatedDistance;
}

function calculate_distance($lat1, $lon1, $lat2, $lon2, $unit = 'N')
{
    $theta = $lon1 - $lon2;
    $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
    $dist = acos($dist);
    $dist = rad2deg($dist);
    $miles = $dist * 60 * 1.1515;
    $unit = strtoupper($unit);

    if ($unit == "K") {
        return ($miles * 1.609344);
    } else if ($unit == "N") {
        return ($miles * 0.8684);
    } else {
        return $miles;
    }
}

function saveVisitTagging($conn, $reqData)
{

    if ($reqData['visit_type'] == "SURV" && $reqData['user_role'] == "SMUSER") {
        echo json_encode(['status' => 0, 'message' => "Sorry SM are not allowed to scan for House Visits"]);
        exit;
    }

    if ($reqData['visit_type'] == "SURV" &&  substr($reqData['uniq_ref_id'], 0, 4)  == "HOSV") {
        echo json_encode(['status' => 0, 'message' => "Please select proper activity type"]);
        exit;
    }

    if ($reqData['visit_type'] == "HOSV" &&  substr($reqData['uniq_ref_id'], 0, 3)  == "SRV") {
        echo json_encode(['status' => 0, 'message' => "Please select proper activity type"]);
        exit;
    }

    // if(!isset($reqData['unit_cd']) || $reqData['unit_cd'] == ""){
    //     echo json_encode(['status' => 0, 'message' => "Please select proper activity type"]);
    //     exit;
    // }



    $I_SST_VISIT_TYPE = $reqData['visit_type'];
    $I_SST_UNIQ_REF_ID = $reqData['uniq_ref_id'];
    $I_SST_VISIT_DATE = date("d-M-Y", strtotime($reqData['visit_date']));
    $I_SST_REMARKS = $reqData['remarks'];
    $I_SST_ACCM_WITH = $reqData['accm_with'];
    $I_SST_ACCM_ROLE = $reqData['accm_role'];
    $I_SST_ACCM_LATITUDE = $reqData['accm_latitude'];
    $I_SST_ACCM_LONGITUDE = $reqData['accm_longitude'];
    $I_SST_USER_LATITUDE = $reqData['user_latitude'];
    $I_SST_USER_LONGITUDE = $reqData['user_longitude'];
    $I_SST_DIST_DIFFERENCE = calculate_distance($I_SST_ACCM_LATITUDE, $I_SST_ACCM_LONGITUDE, $I_SST_USER_LATITUDE, $I_SST_USER_LONGITUDE, "K");
    $I_SST_USER_ID = $reqData['user_id'];
    $I_SST_USER_ROLE =  $reqData['user_role'];
    $I_SST_CREATED_BY = $reqData['created_by'];
    $I_SST_CREATED_AT = date("d-M-Y H:i:s", strtotime($reqData['created_at']));
    $I_SST_UPDATED_BY = $reqData['updated_by'];
    $I_SST_UPDATED_AT = date("d-M-Y H:i:s", strtotime($reqData['updated_at']));
    $I_SST_STATUS = $reqData['status'];
    $I_SST_SYNC_DATE = "xxxx";
    $I_SST_UNIT_CD = $reqData['unit_cd'] ?? 0;


    // echo json_encode(['status'=> 0,'message'=> $I_SST_CREATED_AT ]);
    // exit;


    $query = "begin PKGPH_SM_SURVEY_2021.PRC_I_VISIT_TAGGING
	(
         :I_SST_VISIT_TYPE      
        ,:I_SST_UNIQ_REF_ID     
        ,:I_SST_VISIT_DATE      
        ,:I_SST_REMARKS         
        ,:I_SST_ACCM_WITH       
        ,:I_SST_ACCM_ROLE       
        ,:I_SST_ACCM_LATITUDE   
        ,:I_SST_ACCM_LONGITUDE  
        ,:I_SST_USER_LATITUDE   
        ,:I_SST_USER_LONGITUDE  
        ,:I_SST_DIST_DIFFERENCE 
        ,:I_SST_USER_ID         
        ,:I_SST_USER_ROLE       
        ,:I_SST_CREATED_BY      
        ,:I_SST_CREATED_AT      
        ,:I_SST_UPDATED_BY      
        ,:I_SST_UPDATED_AT      
        ,:I_SST_STATUS          
        ,:I_SST_SYNC_DATE
        ,:I_SST_UNIT_CD             
        ,:O_STATUS              
        ,:O_MESSAGE                    
	); 
	end;";
    $stid = oci_parse($conn, $query);


    if (!$stid) {
        $e = oci_error($conn);  // For oci_parse errors pass the connection handle
        echo json_encode(['status' => "0", 'message' => "ERROR_PARSE"]);
        exit();
    }


    oci_bind_by_name($stid, ':I_SST_VISIT_TYPE', $I_SST_VISIT_TYPE, 100);
    oci_bind_by_name($stid, ':I_SST_UNIQ_REF_ID', $I_SST_UNIQ_REF_ID, 100);
    oci_bind_by_name($stid, ':I_SST_VISIT_DATE', $I_SST_VISIT_DATE, 100);
    oci_bind_by_name($stid, ':I_SST_REMARKS', $I_SST_REMARKS, 100);
    oci_bind_by_name($stid, ':I_SST_ACCM_WITH', $I_SST_ACCM_WITH, 100);
    oci_bind_by_name($stid, ':I_SST_ACCM_ROLE', $I_SST_ACCM_ROLE, 100);
    oci_bind_by_name($stid, ':I_SST_ACCM_LATITUDE', $I_SST_ACCM_LATITUDE, 100);
    oci_bind_by_name($stid, ':I_SST_ACCM_LONGITUDE', $I_SST_ACCM_LONGITUDE, 100);
    oci_bind_by_name($stid, ':I_SST_USER_LATITUDE', $I_SST_USER_LATITUDE, 100);
    oci_bind_by_name($stid, ':I_SST_USER_LONGITUDE', $I_SST_USER_LONGITUDE, 100);
    oci_bind_by_name($stid, ':I_SST_DIST_DIFFERENCE', $I_SST_DIST_DIFFERENCE, 100);
    oci_bind_by_name($stid, ':I_SST_USER_ID', $I_SST_USER_ID, 100);
    oci_bind_by_name($stid, ':I_SST_USER_ROLE', $I_SST_USER_ROLE, 100);
    oci_bind_by_name($stid, ':I_SST_CREATED_BY', $I_SST_CREATED_BY, 100);
    oci_bind_by_name($stid, ':I_SST_CREATED_AT', $I_SST_CREATED_AT, 100);
    oci_bind_by_name($stid, ':I_SST_UPDATED_BY', $I_SST_UPDATED_BY, 100);
    oci_bind_by_name($stid, ':I_SST_UPDATED_AT', $I_SST_UPDATED_AT, 100);
    oci_bind_by_name($stid, ':I_SST_STATUS', $I_SST_STATUS, 100);
    oci_bind_by_name($stid, ':I_SST_SYNC_DATE', $I_SST_SYNC_DATE, 100);
    oci_bind_by_name($stid, ':I_SST_UNIT_CD', $I_SST_UNIT_CD, 100);
    oci_bind_by_name($stid, ':O_STATUS', $O_STATUS, 100);
    oci_bind_by_name($stid, ':O_MESSAGE', $O_MESSAGE, 100);



    $r = oci_execute($stid, OCI_NO_AUTO_COMMIT);
    if (!$r) {
        $e = oci_error($stid); // For oci_execute errors pass the statementhandle
        echo json_encode(['status' => 0, 'message' => $e['message']]);
        exit();
    }

    if ($O_STATUS > 0) {
        $r = oci_commit($conn);
        echo json_encode(['status' => 1, 'message' => $O_MESSAGE]);
    } else {
        oci_rollback($conn);
        echo json_encode(['status' => 0, 'message' => $O_MESSAGE . "sssss"]);
    }

    oci_free_statement($stid);
    oci_close($conn);
}

function saveWorkPlan($conn, $reqData)
{




    // $jsonData = '

    // [
    //     {
    //        "planId":"0",
    //        "planDate":"05-JUN-23",
    //        "slotCode":"SLT003",
    //        "cUserCode":"DMW/052",
    //        "cUserRole":"xxxxx",
    //        "pUserCode":"sssss",
    //        "pUserRole":"sssss",
    //        "activitylist":
    //        [
    //           {"activitycode":"AC1" },
    //            {"activitycode":"AC2" }
    //         ]
    //     },
    //     {
    //         "planId":"0",
    //         "planDate":"05-JUN-23",
    //         "slotCode":"SLT0031",
    //         "cUserCode":"DMW/0521",
    //         "cUserRole":"xxx11xx",
    //         "pUserCode":"sss11ss",
    //         "pUserRole":"ss22sss",
    //         "activitylist":[
    //            {"activitycode":"AC3"},
    //            {  "activitycode":"AC4"}

    //         ]
    //      }
    //  ]
    // ';

    $jsonData = $reqData["planData"];

    $arrData = json_decode($jsonData, true);


    //    echo json_encode($reqData);
    //    exit;

    $I_CREATED_BY = "";


    $I_PLAN_ID = [];
    $I_SM_DATE = [];
    $I_SLOT_CD = [];

    foreach ($arrData as $key => $value) {

        $I_PLAN_ID[] = $value["planId"];
        $I_SM_DATE[] = date("d-M-Y", strtotime($value["planDate"]));
        $I_SLOT_CD[] = $value["slotCode"];
        $I_PLAN_FORMAT[] = "MONTHLY";
        $I_C_USER_CODE[] = $value["cUserCode"];
        $I_C_USER_ROLE[] = $value["cUserRole"];
        $I_P_USER_CODE[] = $value["pUserCode"];
        $I_P_USER_ROLE[] = $value["pUserRole"];
        $TMPdATA = [];
        foreach ($value["activitylist"] as $key => $value1) {
            $TMPdATA[] =  $value1["activitycode"];
        }
        $I_Act_Type_Cd[] = implode(",", $TMPdATA);
        $I_CREATED_BY = $value["pUserCode"];
    }

    // echo json_encode(['status' => '0', 'message' =>  json_encode($I_PLAN_ID)]);
    // exit;

    $query = "begin PKG_Work_Plan_DP.PRC_Work_Plan
	(
        :I_PLAN_ID
        ,:I_SM_DATE
        ,:I_SLOT_CD
        ,:I_PLAN_FORMAT
        ,:I_C_USER_CODE
        ,:I_C_USER_ROLE
        ,:I_P_USER_CODE
        ,:I_P_USER_ROLE
        ,:I_Act_Type_Cd
        ,:I_CREATED_BY
        ,:O_Msg
        ,:O_ErrMsg
    );
	end;";
    $stid = oci_parse($conn, $query);


    if (!$stid) {
        $e = oci_error($conn);  // For oci_parse errors pass the connection handle
        echo json_encode(['status' => "0", 'message' => "ERROR_PARSE"]);
        exit();
    }

    $I_PLAN_ID_SIZE = sizeof($I_PLAN_ID);
    $I_SM_DATE_SIZE = sizeof($I_SM_DATE);
    $I_SLOT_CD_SIZE =  sizeof($I_SLOT_CD);
    $I_PLAN_FORMAT_SIZE =  sizeof($I_PLAN_FORMAT);
    $I_C_USER_CODE_SIZE = sizeof($I_C_USER_CODE);
    $I_C_USER_ROLE_SIZE = sizeof($I_C_USER_ROLE);
    $I_P_USER_CODE_SIZE = sizeof($I_P_USER_CODE);
    $I_P_USER_ROLE_SIZE =  sizeof($I_P_USER_ROLE);
    $I_Act_Type_Cd_SIZE =  sizeof($I_Act_Type_Cd);


    oci_bind_array_by_name($stid, ":I_PLAN_ID", $I_PLAN_ID, $I_PLAN_ID_SIZE, -1, SQLT_CHR);
    oci_bind_array_by_name($stid, ":I_SM_DATE", $I_SM_DATE, $I_SM_DATE_SIZE, -1, SQLT_CHR);
    oci_bind_array_by_name($stid, ":I_SLOT_CD", $I_SLOT_CD,  $I_SLOT_CD_SIZE, -1, SQLT_CHR);
    oci_bind_array_by_name($stid, ":I_PLAN_FORMAT", $I_PLAN_FORMAT,  $I_PLAN_FORMAT_SIZE, -1, SQLT_CHR);
    oci_bind_array_by_name($stid, ":I_C_USER_CODE", $I_C_USER_CODE,  $I_C_USER_CODE_SIZE, -1, SQLT_CHR);
    oci_bind_array_by_name($stid, ":I_C_USER_ROLE", $I_C_USER_ROLE,  $I_C_USER_ROLE_SIZE, -1, SQLT_CHR);
    oci_bind_array_by_name($stid, ":I_P_USER_CODE", $I_P_USER_CODE,  $I_P_USER_CODE_SIZE, -1, SQLT_CHR);
    oci_bind_array_by_name($stid, ":I_P_USER_ROLE", $I_P_USER_ROLE,  $I_P_USER_ROLE_SIZE, -1, SQLT_CHR);
    oci_bind_array_by_name($stid, ":I_Act_Type_Cd", $I_Act_Type_Cd,  $I_Act_Type_Cd_SIZE, -1, SQLT_CHR);
    oci_bind_by_name($stid, ":I_CREATED_BY", $I_CREATED_BY, 100);
    oci_bind_by_name($stid, ":O_Msg", $o_status, 100);
    oci_bind_by_name($stid, ":O_ErrMsg", $o_msg, 100);
    $r = oci_execute($stid, OCI_NO_AUTO_COMMIT);
    if (!$r) {
        $e = oci_error($stid); // For oci_execute errors pass the statementhandle
        echo json_encode(['status' => 0, 'message' => $e['message']]);
        exit();
    }

    if ($o_status > 0) {
        oci_commit($conn);
        echo json_encode(['status' => 1, 'message' => $o_msg]);
    } else {
        oci_rollback($conn);

        echo json_encode(['status' => 0, 'message' => $o_msg]);
    }


    oci_free_statement($stid);
    oci_close($conn);
}

function getIdentPatients($conn, $postData)
{
    $resultData = [];
    $I_EMP_CD = $postData["user_id"];
    $I_USER_ROLE = $postData["user_role"];

    $curs = oci_new_cursor($conn);
    $query = "begin PKGPH_SM_SURVEY_FOLLOWUP.PRC_POPU_IDNTF_PATIENTS 
	(
         :I_EMP_CD      
        ,:I_USER_ROLE   
        ,:cS_Data
	); 
	end;";
    $stid = oci_parse($conn, $query);
    $data = "";
    if ($stid) {
        oci_bind_by_name($stid, ':I_EMP_CD', $I_EMP_CD, 100);
        oci_bind_by_name($stid, ':I_USER_ROLE', $I_USER_ROLE, 100);
        oci_bind_by_name($stid, ":cS_Data", $curs, -1, OCI_B_CURSOR);
        $r = oci_execute($stid);
        if ($r) {
            $r1 = oci_execute($curs);
            if ($r1) {
                while (($r = oci_fetch_array($curs, OCI_ASSOC + OCI_RETURN_NULLS)) != false) {

                    if ($I_EMP_CD == "1819") {
                        $resultData[] = $r;
                    } else {
                        $resultData[] = [];
                    }
                }
                echo json_encode($resultData);
            } else {
                $e = oci_error($curs); // For oci_execute errors pass the statementhandle
                // echo "No Data Found";
            }
        } else {
            $e = oci_error($stid); // For oci_execute errors pass the statementhandle
            // echo htmlentities($e['message']);
            exit;
        }
    } else {
        $e = oci_error($conn);  // For oci_parse errors pass the connection handle
        echo htmlentities($e['message']);
    }

    oci_free_statement($stid);
    oci_free_statement($curs);
    oci_close($conn);
}

function getFollowupPatientDetail($conn, $postData)
{
    $resultData = [];
    $I_SURVEY_ID = $postData["survey_id"];

    $curs = oci_new_cursor($conn);
    $query = "begin PKG_Work_Plan_DP.PRC_POPU_FOLLOWUP_HIST 
	(
        :I_SURVEY_ID,   
        :cS_Data,
        :O_Msg,
        :O_ErrMsg
	); 
	end;";
    $stid = oci_parse($conn, $query);
    $data = "";
    if ($stid) {
        oci_bind_by_name($stid, ':I_SURVEY_ID', $I_SURVEY_ID, 100);
        oci_bind_by_name($stid, ":cS_Data", $curs, -1, OCI_B_CURSOR);
        oci_bind_by_name($stid, ':O_Msg', $O_Msg, 100);
        oci_bind_by_name($stid, ':O_ErrMsg', $O_ErrMsg, 100);

        $r = oci_execute($stid);
        if ($r) {
            $r1 = oci_execute($curs);
            if ($r1) {
                while (($r = oci_fetch_array($curs, OCI_ASSOC + OCI_RETURN_NULLS)) != false) {
                    $resultData[] = $r;
                }
                echo json_encode($resultData);
            } else {
                $e = oci_error($curs); // For oci_execute errors pass the statementhandle
                // echo "No Data Found";
            }
        } else {
            $e = oci_error($stid); // For oci_execute errors pass the statementhandle
            // echo htmlentities($e['message']);
            exit;
        }
    } else {
        $e = oci_error($conn);  // For oci_parse errors pass the connection handle
        echo htmlentities($e['message']);
    }

    oci_free_statement($stid);
    oci_free_statement($curs);
    oci_close($conn);
}

function saveFollowup($conn, $reqData)
{


    $I_SURVEY_ID = $reqData["survey_id"];
    $I_PATIENT_ID = $reqData["patient_id"];
    $I_FWP_DATE =  date("d-M-Y", strtotime($reqData["followup_date"]));
    $I_FWP_MODE = $reqData["followup_mode"];
    $I_FWP_OUT_COME = $reqData["followup_outcome"];
    $I_FWP_REMARK = $reqData["followup_remarks"];
    $I_FWP_NEXT_DT = date("d-M-Y", strtotime($reqData["followup_postponed_date"]));
    // $reqData["followup_postponed_date"];
    $I_SM_USER_ID = $reqData["sm_cd"];



    $query = "begin PKG_Work_Plan_DP.PRC_I_FOLLOWUP
	(

         :I_SURVEY_ID     
        ,:I_PATIENT_ID    
        ,:I_FWP_DATE      
        ,:I_FWP_MODE      
        ,:I_FWP_OUT_COME  
        ,:I_FWP_REMARK    
        ,:I_FWP_NEXT_DT   
        ,:I_SM_USER_ID    
        ,:O_Msg           
        ,:O_ErrMsg        

    );
	end;";
    $stid = oci_parse($conn, $query);


    if (!$stid) {
        $e = oci_error($conn);  // For oci_parse errors pass the connection handle
        echo json_encode(['status' => "0", 'message' => "ERROR_PARSE"]);
        exit();
    }






    oci_bind_by_name($stid, ":I_SURVEY_ID", $I_SURVEY_ID, 100);
    oci_bind_by_name($stid, ":I_PATIENT_ID", $I_PATIENT_ID, 100);
    oci_bind_by_name($stid, ":I_FWP_DATE", $I_FWP_DATE, 100);
    oci_bind_by_name($stid, ":I_FWP_MODE", $I_FWP_MODE, 100);
    oci_bind_by_name($stid, ":I_FWP_OUT_COME", $I_FWP_OUT_COME, 100);
    oci_bind_by_name($stid, ":I_FWP_REMARK", $I_FWP_REMARK, 100);
    oci_bind_by_name($stid, ":I_FWP_NEXT_DT", $I_FWP_NEXT_DT, 100);
    oci_bind_by_name($stid, ":I_SM_USER_ID", $I_SM_USER_ID, 100);
    oci_bind_by_name($stid, ":O_Msg", $o_status, 100);
    oci_bind_by_name($stid, ":O_ErrMsg", $o_msg, 100);
    $r = oci_execute($stid, OCI_NO_AUTO_COMMIT);
    if (!$r) {
        $e = oci_error($stid); // For oci_execute errors pass the statementhandle
        echo json_encode(['status' => 0, 'message' => $e['message'] . "zzzzzzz1111" . json_encode($reqData)]);



        exit();
    }

    if ($o_status > 0) {
        oci_commit($conn);
        echo json_encode(['status' => 1, 'message' => $o_msg]);
    } else {
        oci_rollback($conn);

        echo json_encode(['status' => 0, 'message' => $o_msg]);
    }


    oci_free_statement($stid);
    oci_close($conn);
}

function saveSurveyCallLogs($conn, $reqData)
{

    date_default_timezone_set("Asia/Kolkata");

    // $I_CONTACT_NO = $reqData['contact_no'];
    // $I_CALL_TYPE = $reqData['call_type'];
    // $I_CALL_DATE = $reqData['call_date'];
    // $I_CALL_DURATION = $reqData['call_duration'];

    $CALL_LOGS = json_decode($reqData['call_log'], true);

    $I_CONTACT_NO_ARR = [];
    $I_CALL_TYPE_ARR = [];
    $I_CALL_DATE_ARR = [];
    $I_CALL_DURATION_ARR = [];

    foreach ($CALL_LOGS as $key => $value) {
        $I_CONTACT_NO_ARR[] = $value['contact_no'];
        $I_CALL_TYPE_ARR[] = $value['call_type'];
        $I_CALL_DATE_ARR[] = DATE("d-M-Y H:i:s", strtotime($value['call_date']));
        $I_CALL_DURATION_ARR[] = $value['call_duration'];
    }

    $I_CONTACT_NO_SIZE = sizeof($I_CONTACT_NO_ARR);
    $I_CALL_TYPE_SIZE = sizeof($I_CALL_TYPE_ARR);
    $I_CALL_DATE_SIZE = sizeof($I_CALL_DATE_ARR);
    $I_CALL_DURATION_SIZE = sizeof($I_CALL_DURATION_ARR);


    //  echo json_encode(['status' => 0, 'message' => json_encode($I_CALL_DATE_SIZE)]);
    //  EXIT;



    $I_REMARKS = $reqData['call_remarks'];
    $I_CALLER_ID = $reqData['caller_id'];
    $I_CALLER_ROLE = $reqData['caller_role'];
    $I_RECEIVER_ID = $reqData['receiver_id'];
    $I_RECEIVER_ROLE = $reqData['receiver_role'];
    $I_CREATED_BY = $reqData['user_id'];

    $query = "begin PKGPH_SM_CALL_LOG.PRC_I_SM_SURVEY_CALL_LOGS
	(
         :I_CONTACT_NO   
        ,:I_CALL_TYPE     
        ,:I_CALL_DATE    
        ,:I_CALL_DURATION      
        ,:I_REMARKS      
        ,:I_CALLER_ID  
        ,:I_CALLER_ROLE    
        ,:I_RECEIVER_ID   
        ,:I_RECEIVER_ROLE
        ,:I_CREATED_BY    
        ,:O_Msg                       
        ,:O_ErrMsg                 

    );
	end;";


    $stid = oci_parse($conn, $query);


    if (!$stid) {
        $e = oci_error($conn);  // For oci_parse errors pass the connection handle
        echo json_encode(['status' => "0", 'message' => "ERROR_PARSE"]);
        exit();
    }


    //  oci_bind_array_by_name($stid, ":i_Family_Survey_Type", $i_Family_Survey_Type_arr, $i_Family_Survey_Type_size, -1, SQLT_CHR);



    oci_bind_array_by_name($stid, ":I_CONTACT_NO", $I_CONTACT_NO_ARR, $I_CONTACT_NO_SIZE, 100 - 1, SQLT_CHR);
    oci_bind_array_by_name($stid, ":I_CALL_TYPE", $I_CALL_TYPE_ARR, $I_CALL_TYPE_SIZE, 100 - 1, SQLT_CHR);
    oci_bind_array_by_name($stid, ":I_CALL_DATE", $I_CALL_DATE_ARR, $I_CALL_DATE_SIZE, 100 - 1, SQLT_CHR);
    oci_bind_array_by_name($stid, ":I_CALL_DURATION", $I_CALL_DURATION_ARR, $I_CALL_DURATION_SIZE, 100 - 1, SQLT_CHR);
    oci_bind_by_name($stid, ":I_REMARKS", $I_REMARKS, 100);
    oci_bind_by_name($stid, ":I_CALLER_ID", $I_CALLER_ID, 100);
    oci_bind_by_name($stid, ":I_CALLER_ROLE", $I_CALLER_ROLE, 100);
    oci_bind_by_name($stid, ":I_RECEIVER_ID", $I_RECEIVER_ID, 100);
    oci_bind_by_name($stid, ":I_RECEIVER_ROLE", $I_RECEIVER_ROLE, 100);
    oci_bind_by_name($stid, ":I_CREATED_BY", $I_CREATED_BY, 100);
    oci_bind_by_name($stid, ":O_Msg", $o_status, 100);
    oci_bind_by_name($stid, ":O_ErrMsg", $o_msg, 100);
    $r = oci_execute($stid, OCI_NO_AUTO_COMMIT);
    if (!$r) {
        $e = oci_error($stid); // For oci_execute errors pass the statementhandle
        echo json_encode(['status' => 0, 'message' => $e['message'] . "zzzzzzz1111" . json_encode($reqData)]);



        exit();
    }

    if ($o_status > 0) {
        oci_commit($conn);
        echo json_encode(['status' => 1, 'message' => $o_msg]);
    } else {
        oci_rollback($conn);

        echo json_encode(['status' => 0, 'message' => $o_msg]);
    }


    oci_free_statement($stid);
    oci_close($conn);
}

function getSurveyCallLogs($conn, $reqData)
{



    $resultData = [];
    $I_CONTACT_NO = $reqData["contact_no"];
    $I_USER_ID = $reqData["user_id"];

    $curs = oci_new_cursor($conn);
    $query = "begin PKGPH_SM_CALL_LOG.PRC_POPU_CALL_LOG 
	(
        :i_CONTACT_NO,   
        :I_USER_ID,   
        :cS_Data
	); 
	end;";
    $stid = oci_parse($conn, $query);
    $data = "";
    if ($stid) {
        oci_bind_by_name($stid, ':I_CONTACT_NO', $I_CONTACT_NO, 100);
        oci_bind_by_name($stid, ':I_USER_ID', $I_USER_ID, 100);
        oci_bind_by_name($stid, ":cS_Data", $curs, -1, OCI_B_CURSOR);
        $r = oci_execute($stid);
        if ($r) {
            $r1 = oci_execute($curs);
            if ($r1) {
                while (($r = oci_fetch_array($curs, OCI_ASSOC + OCI_RETURN_NULLS)) != false) {
                    $resultData[] = $r;
                }
                echo json_encode($resultData);
            } else {
                $e = oci_error($curs); // For oci_execute errors pass the statementhandle
                // echo "No Data Found";
            }
        } else {
            $e = oci_error($stid); // For oci_execute errors pass the statementhandle
            // echo htmlentities($e['message']);
            exit;
        }
    } else {
        $e = oci_error($conn);  // For oci_parse errors pass the connection handle
        echo htmlentities($e['message']);
    }

    oci_free_statement($stid);
    oci_free_statement($curs);
    oci_close($conn);
}

function getHsvPidTargAchv($conn, $reqData)
{

    $i_UsrId = $reqData['user_id'];
    $i_UsrRol = $reqData['user_role'];
    $i_UsrLoc = "AS";
    $curs = oci_new_cursor($conn);
    $query = "begin PKGPH_SM_MIS.PRC_POPU_DASHBOARD_CNT_EXT 
	(
        :i_UsrId          
        ,:i_UsrRol         
        ,:i_UsrLoc         
        ,:cS_Data          
	); 
	end;";
    $stid = oci_parse($conn, $query);

    if (!$stid) {
        $e = oci_error($conn);  // For oci_parse errors pass the connection handle
        return json_encode(['status' => 0, 'message' => htmlentities($e['message'])]);
        exit;
    }

    oci_bind_by_name($stid, ':i_UsrId', $i_UsrId, 100);
    oci_bind_by_name($stid, ':i_UsrRol', $i_UsrRol, 100);
    oci_bind_by_name($stid, ':i_UsrLoc', $i_UsrLoc, 100);
    oci_bind_by_name($stid, ":cS_Data", $curs, -1, OCI_B_CURSOR);
    $r = oci_execute($stid);
    if (!$r) {
        $e = oci_error($stid);
        oci_free_statement($stid);
        oci_free_statement($curs);
        oci_close($conn);
        return json_encode(['status' => 0, 'message' => htmlentities($e['message'])]);
        exit;
    }

    $r1 = oci_execute($curs);
    if (!$r1) {
        $e = oci_error($curs);
        oci_free_statement($stid);
        oci_free_statement($curs);
        oci_close($conn);
        return json_encode(['status' => 0, 'message' => htmlentities($e['message'])]);
        exit;
    }
    $data = [];
    while (($r = oci_fetch_array($curs, OCI_ASSOC + OCI_RETURN_NULLS)) != false) {
        $data[] = $r;
    }
    echo json_encode(['status' => 1, 'message' => 'Success', 'data' => $data]);
}

# [5376][24-01-2024 10:00 AM] : TO GET USER WISE TARGET ACHIEVMENT LIST
function getUserWiseTargetAchievementList($conn, $reqData)
{

    $curlHandle = curl_init("http://10.0.3.8/swasthyamitra/api/1.0/index_test.php");
    curl_setopt($curlHandle, CURLOPT_POSTFIELDS, $reqData);
    curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
    $curlResponse = curl_exec($curlHandle);
    $patTargetArr = json_decode($curlResponse, true);
    curl_close($curlHandle);

    //exit;
    $x = [];

    if ($patTargetArr['status'] == 0) {
        echo json_encode(['status' => 0, 'message' => $patTargetArr['message'], 'data' => $x]);
        exit;
    }





    foreach ($patTargetArr["data"] as $key => $value) {
        $x[] = [
            "type" => 'OPD',
            "target" => $value['OP_CNT_TGT'],
            "achieved" => $value['OP_CNT_ACHV']
        ];
        $x[] = [
            "type" => 'IPD',
            "target" => $value['IP_CNT_TGT'],
            "achieved" => $value['IP_CNT_ACHV']
        ];
    }

    $response = getDailySurveyCnt($conn, $reqData);
    // echo json_encode($response);

    if ($response['status'] > 0) {
        foreach ($response['data'] as $key => $value) {

            $x[] = [
                "type" => 'HSV',
                "target" => $value['HSV_CNT_TGT'],
                "achieved" =>  $value['HSV_CNT_ACHV']
            ];
            $x[] = [
                "type" => 'MEMB_SCR',
                "target" => $value['MEMB_SCRN_TGT'],
                "achieved" => $value['MEMB_SCR_ACHV']
            ];
            $x[] = [
                "type" => 'PAT_IDNT',
                "target" => $value['PAT_IDNT_TGT'],
                "achieved" => $value['PAT_IDNT_ACHV']
            ];
        }
    }

    $x[] = [
        "type" => 'COMM',
        "target" => 0,
        "achieved" => 0
    ];

    $x[] = [
        "type" => 'FOLLOWUP',
        "target" => 0,
        "achieved" => 0
    ];

    echo json_encode(['status' => 1, 'message' => 'Success', 'data' => $x]);
}

# [5376][24-01-2024 10:00 AM] : TO GET DAILY SURVEY COUNT DETAILS
function getDailySurveyCnt($conn, $reqData)
{

    $I_USER_ID = $reqData['user_id'];
    $I_USER_ROLE = $reqData['user_role'];
    $I_STATE_CD = "AS";
    $curs = oci_new_cursor($conn);


    $query = "begin PKGPH_TEST_KKP.PRC_R_DAILY_SURV_CNT 
	(
        :I_USER_ID          
        ,:I_USER_ROLE         
        ,:I_STATE_CD         
        ,:cS_Data 
        ,:O_STATUS
        ,:O_MESSAGE         
	); 
	end;";
    $stid = oci_parse($conn, $query);

    if (!$stid) {
        $e = oci_error($conn);  // For oci_parse errors pass the connection handle
        return ['status' => 0, 'message' => htmlentities($e['message'])];
        exit;
    }

    oci_bind_by_name($stid, ':I_USER_ID', $I_USER_ID, 100);
    oci_bind_by_name($stid, ':I_USER_ROLE', $I_USER_ROLE, 100);
    oci_bind_by_name($stid, ':I_STATE_CD', $I_STATE_CD, 100);
    oci_bind_by_name($stid, ":cS_Data", $curs, -1, OCI_B_CURSOR);
    oci_bind_by_name($stid, ':O_STATUS', $O_STATUS, 100);
    oci_bind_by_name($stid, ':O_MESSAGE', $O_MESSAGE, 100);
    $r = oci_execute($stid);
    if (!$r) {
        $e = oci_error($stid);
        oci_free_statement($stid);
        oci_free_statement($curs);
        oci_close($conn);
        return ['status' => 0, 'message' => htmlentities($e['message'])];;
        exit;
    }

    $r1 = oci_execute($curs);
    if (!$r1) {
        $e = oci_error($curs);
        oci_free_statement($stid);
        oci_free_statement($curs);
        oci_close($conn);
        return json_encode(['status' => 0, 'message' => htmlentities($e['message'])]);
        exit;
    }
    $data = [];
    if ($O_STATUS > 0) {
        while (($r = oci_fetch_array($curs, OCI_ASSOC + OCI_RETURN_NULLS)) != false) {
            $data[] = $r;
        }
    }
    return ['status' => $O_STATUS, 'message' => $O_MESSAGE, 'data' => $data];
}

# [5376][22-01-2024 01:15 PM] : TO GET LIST OF REMARKS OF COMMUNITY MEETING CLOSE
function getCommunityMeetingCloseRemarks($conn, $reqData)
{

    $I_PARAM_TYPE = "CCMR";

    $curs = oci_new_cursor($conn);
    $query = "begin PKGPH_TEST_KKP.PRC_POPU_COMMON_PARAMS 
	(
        :I_PARAM_TYPE                
        ,:cS_Data 
        ,:O_STATUS                 
        ,:O_MESSAGE                 
	); 
	end;";
    $stid = oci_parse($conn, $query);

    if (!$stid) {
        $e = oci_error($conn);  // For oci_parse errors pass the connection handle
        return json_encode(['status' => 0, 'message' => htmlentities($e['message'])]);
        exit;
    }

    oci_bind_by_name($stid, ':I_PARAM_TYPE', $I_PARAM_TYPE, 100);
    oci_bind_by_name($stid, ":cS_Data", $curs, -1, OCI_B_CURSOR);
    oci_bind_by_name($stid, ':O_STATUS', $O_STATUS, 100);
    oci_bind_by_name($stid, ':O_MESSAGE', $O_MESSAGE, 100);
    $r = oci_execute($stid);
    if (!$r) {
        $e = oci_error($stid);
        oci_free_statement($stid);
        oci_free_statement($curs);
        oci_close($conn);
        return json_encode(['status' => 0, 'message' => htmlentities($e['message'])]);
        exit;
    }

    $r1 = oci_execute($curs);
    if (!$r1) {
        $e = oci_error($curs);
        oci_free_statement($stid);
        oci_free_statement($curs);
        oci_close($conn);
        return json_encode(['status' => 0, 'message' => htmlentities($e['message'])]);
        exit;
    }
    $data = [];
    while (($r = oci_fetch_array($curs, OCI_ASSOC + OCI_RETURN_NULLS)) != false) {
        $data[] = [
            'PARAM_CD' => $r['SCNPM_CD'],
            'PARAM_DESC' => $r['SCNPM_DESC']
        ];
    }
    echo json_encode(['status' => 1, 'message' => 'Success', 'data' => $data]);
}

# [5376][22-01-2024 01:15 PM] : TO CLOSE COMMUNITY MEETING
function closeCommunityMeeting($conn, $reqData)
{


    $I_CMTY_MEETING_ID = $reqData['meeting_id'];
    $I_USER_ID = $reqData['user_id'];
    $I_ACTION_TYPE = $reqData['action_type'];
    $I_ACTION_RMRK_CD = $reqData['action_rmrk_cd'];
    $I_ACTION_RMRK_DTL = $reqData['action_rmrk_dtl'];



    $query = "begin PKGPH_TEST_KKP.PRC_CLOSE_COMTY_MTNG
	(
        :I_CMTY_MEETING_ID,
        :I_USER_ID,
        :I_ACTION_TYPE,
        :I_ACTION_RMRK_CD,
        :I_ACTION_RMRK_DTL,
        :O_STATUS,
        :O_MESSAGE
                                     
	); 
	end;";
    $stid = oci_parse($conn, $query);


    if (!$stid) {
        $e = oci_error($conn);  // For oci_parse errors pass the connection handle
        echo json_encode(['status' => "0", 'message' => "ERROR_PARSE"]);
        exit();
    }

    oci_bind_by_name($stid, ':I_CMTY_MEETING_ID', $I_CMTY_MEETING_ID, 100);
    oci_bind_by_name($stid, ':I_USER_ID', $I_USER_ID, 100);
    oci_bind_by_name($stid, ':I_ACTION_TYPE', $I_ACTION_TYPE, 100);
    oci_bind_by_name($stid, ':I_ACTION_RMRK_CD', $I_ACTION_RMRK_CD, 100);
    oci_bind_by_name($stid, ':I_ACTION_RMRK_DTL', $I_ACTION_RMRK_DTL, 100);
    oci_bind_by_name($stid, ':O_MESSAGE', $O_MESSAGE, 100);
    oci_bind_by_name($stid, ':O_STATUS', $O_STATUS, 100);




    $r = oci_execute($stid, OCI_NO_AUTO_COMMIT);
    if (!$r) {
        $e = oci_error($stid); // For oci_execute errors pass the statementhandle
        echo json_encode(['status' => 0, 'message' => $e['message']]);
        exit();
    }

    if ($O_STATUS > 0) {
        $r = oci_commit($conn);
    } else {
        oci_rollback($conn);
    }
    echo json_encode(['status' => $O_STATUS, 'message' => $O_MESSAGE]);



    oci_free_statement($stid);
    oci_close($conn);
}
# [5376][02-02-2024 12:30 PM] : TO CLOSE COMMUNITY MEETING
function getWorkplanSlots($conn, $reqData)
{
    $curs = oci_new_cursor($conn);
    $query = "BEGIN PKGPH_TEST_KKP.PRC_POPU_WORKPLAN_SLOTS(
        :I_USER_ID,
        :I_USER_ROLE_CD,
        :O_CUR_REP,
        :O_STATUS,
        :O_MESSAGE
        );
        END;";
    $stid = oci_parse($conn, $query);
    $list = [];

    if ($stid) {
        oci_bind_by_name($stid, ":I_USER_ID", $reqData["user_id"], 100);
        oci_bind_by_name($stid, ":I_USER_ROLE_CD", $reqData["user_role"], 100);
        oci_bind_by_name($stid, ':O_CUR_REP', $curs, -1, OCI_B_CURSOR);
        oci_bind_by_name($stid, ":O_STATUS", $O_STATUS, 100);
        oci_bind_by_name($stid, ":O_MESSAGE", $O_MESSAGE, 100);
        $r = oci_execute($stid);
        if ($r) {
            if ($O_STATUS > 0) {
                $r1 = oci_execute($curs);
                if ($r1) {
                    while (($row = oci_fetch_array($curs, OCI_ASSOC + OCI_RETURN_NULLS)) != false) {
                        array_push($list, $row);
                    }
                }
            }
            $responseData = ['status' => $O_STATUS, 'message' => $O_MESSAGE, 'data' => $list];
        } else {
            $e = oci_error($stid);
            $responseData = ['status' => 0, 'message' => $e['message'] . "3"];
        }
    } else {
        $e = oci_error($conn);
        $responseData = ['status' => 0, 'message' => $e['message'] . "4"];
    }
    oci_free_statement($stid);
    oci_free_statement($curs);
    oci_close($conn);
    echo json_encode($responseData);
}

# [5376][02-02-2024 12:30 PM] : TO create workplan in app
function createWorkplanApp($conn, $reqData)
{


    $query = "BEGIN PKGPH_TEST_KKP.PRC_CRT_WORKPLAN_APP(
        :I_PLAN_DT,
        :I_SLOT_CD,
        :I_ACTIVITY_CD,
        :I_ASSISTANT_ID,
        :I_USER_ID,
        :I_USER_ROLE_CD,
        :I_STATE_CD,
        :O_STATUS,
        :O_MESSAGE
    );
    END;";

    $stid = oci_parse($conn, $query);

    if (!$stid) {
        $e = oci_error($conn);
        echo json_encode(array('status' => 0, 'message' => $e['message']));
    }

    oci_bind_by_name($stid, ':I_PLAN_DT', $reqData["plan_dt"], 100);
    oci_bind_by_name($stid, ':I_SLOT_CD', $reqData["slot_cd"], 100);
    oci_bind_by_name($stid, ':I_ACTIVITY_CD', $reqData["activity_cd"], 100);
    oci_bind_by_name($stid, ':I_ASSISTANT_ID', $reqData["assistant_id"], 100);
    oci_bind_by_name($stid, ':I_USER_ID', $reqData["user_id"], 100);
    oci_bind_by_name($stid, ':I_USER_ROLE_CD', $reqData["user_role"], 100);
    oci_bind_by_name($stid, ':I_STATE_CD', $reqData["state_cd"], 100);
    oci_bind_by_name($stid, ':O_STATUS', $O_STATUS, 100);
    oci_bind_by_name($stid, ':O_MESSAGE', $O_MESSAGE, 100);

    $r = oci_execute($stid, OCI_NO_AUTO_COMMIT);
    if (!$r) {
        oci_rollback($conn);
        $e = oci_error($stid);
        echo json_encode(array('status' => 0, 'message' => "2" . $e['message']));
        oci_free_statement($stid);
        oci_close($conn);
        exit();
    }

    if ($O_STATUS == 0) {
        oci_rollback($conn);
        $e = oci_error($stid);
        echo json_encode(array('status' => 0, 'message' => $O_MESSAGE));
        oci_free_statement($stid);
        oci_close($conn);
        exit();
    }

    $r = oci_commit($conn);
    if (!$r) {
        $e = oci_error($conn);
        echo json_encode(array('status' => 0, 'message' => "4" . $e['message']));
        oci_free_statement($stid);
        oci_close($conn);
        exit();
    }
    if ($O_STATUS > 0) {
        echo json_encode(array('status' => $O_STATUS, 'message' => $O_MESSAGE));
    }
    oci_free_statement($stid);
    oci_close($conn);
}


# [5376][03-02-2024 03:12 PM] : to delete workplan
function deleteWorkplan($conn, $reqData)
{

    $query = "BEGIN PKGPH_TEST_KKP.PRC_DELT_WORKPLAN(
		:I_WORKPLAN_ID,
		:I_USER_ID,
		:I_USER_ROLE,
		:I_STATE_CD,
		:O_STATUS,
		:O_MESSAGE
	);
	END;";


    $stid = oci_parse($conn, $query);

    if (!$stid) {
        $e = oci_error($conn);
        $responseData = array('status' => 0, 'message' => $e['message']);
        echo json_encode($responseData);
        exit;
    }

    oci_bind_by_name($stid, ':I_WORKPLAN_ID',  $reqData["workplan_id"], 100);
    oci_bind_by_name($stid, ':I_USER_ID',  $reqData["user_id"], 100);
    oci_bind_by_name($stid, ':I_USER_ROLE',  $reqData["user_role"], 100);
    oci_bind_by_name($stid, ':I_STATE_CD',  $reqData["state_cd"], 100);
    oci_bind_by_name($stid, ':O_STATUS',  $O_STATUS, 100);
    oci_bind_by_name($stid, ':O_MESSAGE',  $O_MESSAGE, 100);

    $r = oci_execute($stid, OCI_NO_AUTO_COMMIT);
    if (!$r) {
        oci_rollback($conn);
        $e = oci_error($stid);
        $responseData = array('status' => 0, 'message' => "2" . $e['message']);
        echo json_encode($responseData);
        oci_free_statement($stid);
        oci_close($conn);
        exit();
    }

    if ($O_STATUS < 1) {
        oci_rollback($conn);
        $e = oci_error($stid);
        $responseData = array('status' => $O_STATUS, 'message' => $O_MESSAGE);
        oci_free_statement($stid);
        oci_close($conn);
        echo json_encode($responseData);
        exit();
    }

    $r = oci_commit($conn);
    if (!$r) {
        $e = oci_error($conn);
        $responseData = array('status' => 0, 'message' => "4" . $e['message']);
        oci_free_statement($stid);
        oci_close($conn);
        echo json_encode($responseData);
        exit();
    }

    $responseData = array('status' => $O_STATUS, 'message' => $O_MESSAGE);
    oci_free_statement($stid);
    oci_close($conn);
    echo json_encode($responseData);
}

# [5376][03-02-2024 03:12 PM] : to delete workplan
function getEmpNotWorkingReasons($conn, $reqData)
{
    $curs = oci_new_cursor($conn);
    $query = "BEGIN PKGPH_TEST_KKP.PRC_R_EMP_NOTWORK_RMRK_LIST(
        :I_USER_ID,
        :I_USER_ROLE,
		:I_STATE_CD,
		:O_CUR_REP,
		:O_STATUS,
		:O_MESSAGE
    );
    END;";

    $stid = oci_parse($conn, $query);
    $data = [];

    if ($stid) {
        oci_bind_by_name($stid, ':I_USER_ID',  $reqData["user_id"], 100);
        oci_bind_by_name($stid, ':I_USER_ROLE',  $reqData["user_role"], 100);
        oci_bind_by_name($stid, ':I_STATE_CD',  $reqData["state_cd"], 100);
        oci_bind_by_name($stid, ':O_CUR_REP', $curs, -1, OCI_B_CURSOR);
        oci_bind_by_name($stid, ':O_STATUS',  $O_STATUS, 100);
        oci_bind_by_name($stid, ':O_MESSAGE',  $O_MESSAGE, 100);

        $r = oci_execute($stid);

        if ($r) {

            if ($O_STATUS > 0) {
                oci_execute($curs);
                while (($row = oci_fetch_array($curs, OCI_ASSOC + OCI_RETURN_NULLS)) != false) {
                    array_push($data, $row);
                }
            }
            $responseData = ['status' => $O_STATUS, 'message' => $O_MESSAGE, 'data' => $data];
        } else {
            $e = oci_error($stid);
            $responseData = ['status' => 0, 'message' => $e['message'] . "3"];
        }
    } else {
        $e = oci_error($conn);
        $responseData = ['status' => 0, 'message' => $e['message'] . "4"];
    }
    oci_free_statement($stid);
    oci_free_statement($curs);
    oci_close($conn);
    echo json_encode($responseData);
}


# [8200][05-02-2024 02:38 PM] : to insert sm attendance
function insertSMAttendance($conn, $reqData)
{

    $query = "BEGIN PKGPH_TEST_KKP.PRC_I_SM_ATTENDANCE(
		:I_WORK_STATUS,
		:I_WORK_STATUS_DTL_CD,
		:I_WORK_STATUS_REMARKS,
		:I_USER_ID,
		:I_USER_ROLE,
        :I_STATE_CD,
        :O_STATUS,
		:O_MESSAGE
	);
	END;";


    $stid = oci_parse($conn, $query);

    if (!$stid) {
        $e = oci_error($conn);
        $responseData = array('status' => 0, 'message' => $e['message']);
        echo json_encode($responseData);
        exit;
    }




    oci_bind_by_name($stid, ':I_WORK_STATUS',  $reqData["work_status"], 100);
    oci_bind_by_name($stid, ':I_WORK_STATUS_DTL_CD',  $reqData["work_status_dtl_cd"], 100);
    oci_bind_by_name($stid, ':I_WORK_STATUS_REMARKS',  $reqData["work_status_remarks"], 100);
    oci_bind_by_name($stid, ':I_USER_ID',  $reqData["user_id"], 100);
    oci_bind_by_name($stid, ':I_USER_ROLE',  $reqData["user_role"], 100);
    oci_bind_by_name($stid, ':I_STATE_CD',  $reqData["state_cd"], 100);
    oci_bind_by_name($stid, ':O_STATUS',  $O_STATUS, 100);
    oci_bind_by_name($stid, ':O_MESSAGE',  $O_MESSAGE, 100);

    $r = oci_execute($stid, OCI_NO_AUTO_COMMIT);
    if (!$r) {
        oci_rollback($conn);
        $e = oci_error($stid);
        $responseData = array('status' => 0, 'message' => "2" . $e['message']);
        oci_free_statement($stid);
        oci_close($conn);
        echo json_encode($responseData);
        exit();
    }

    if ($O_STATUS < 1) {
        oci_rollback($conn);
        $e = oci_error($stid);
        $responseData = array('status' => $O_STATUS, 'message' => $O_MESSAGE);
        oci_free_statement($stid);
        oci_close($conn);
        echo json_encode($responseData);
        exit();
    }

    $r = oci_commit($conn);
    if (!$r) {
        $e = oci_error($conn);
        $responseData = array('status' => 0, 'message' => "4" . $e['message']);
        oci_free_statement($stid);
        oci_close($conn);
        echo json_encode($responseData);
        exit();
    }

    $responseData = array('status' => $O_STATUS, 'message' => $O_MESSAGE);
    oci_free_statement($stid);
    oci_close($conn);
    echo json_encode($responseData);
}

# [8200][05-02-2024 04:43 PM] : to get SM data
function getSmAttendanceData($conn, $reqData)
{
    $curs = oci_new_cursor($conn);
    $query = "BEGIN PKGPH_TEST_KKP.PRC_R_SM_ATTENDANCE_DATA(
        :I_FROM_DT,
        :I_TO_DT,
		:I_DURATION,
		:I_USER_ID,
		:I_USER_ROLE,
		:I_STATE_CD,
        :O_CUR_REP,
        :O_STATUS,
        :O_MESSAGE
    );
    END;";

    $stid = oci_parse($conn, $query);
    $data = [];

    if ($stid) {
        oci_bind_by_name($stid, ':I_FROM_DT',  $reqData["from_dt"], 100);
        oci_bind_by_name($stid, ':I_TO_DT',  $reqData["to_dt"], 100);
        oci_bind_by_name($stid, ':I_DURATION',  $reqData["duration"], 100);
        oci_bind_by_name($stid, ':I_USER_ID',  $reqData["user_id"], 100);
        oci_bind_by_name($stid, ':I_USER_ROLE',  $reqData["user_role"], 100);
        oci_bind_by_name($stid, ':I_STATE_CD',  $reqData["state_cd"], 100);
        oci_bind_by_name($stid, ':O_CUR_REP', $curs, -1, OCI_B_CURSOR);
        oci_bind_by_name($stid, ':O_STATUS',  $O_STATUS, 100);
        oci_bind_by_name($stid, ':O_MESSAGE',  $O_MESSAGE, 100);

        $r = oci_execute($stid);

        if ($r) {

            if ($O_STATUS > 0) {
                oci_execute($curs);
                while (($row = oci_fetch_array($curs, OCI_ASSOC + OCI_RETURN_NULLS)) != false) {
                    array_push($data, $row);
                }
            }
            $responseData = ['status' => $O_STATUS, 'message' => $O_MESSAGE, 'data' => $data];
        } else {
            $e = oci_error($stid);
            $responseData = ['status' => 0, 'message' => $e['message'] . "3"];
        }
    } else {
        $e = oci_error($conn);
        $responseData = ['status' => 0, 'message' => $e['message'] . "4"];
    }
    oci_free_statement($stid);
    oci_free_statement($curs);
    oci_close($conn);
    echo json_encode($responseData);
}

# [8200][06-02-2024 03:15 PM] : populate attendance data for authorization request
function populateAttendanceDataForAuthRequest($conn, $reqData)
{
    $curs = oci_new_cursor($conn);
    $query = "BEGIN PKGPH_TEST_KKP.PRC_POPU_ATTND_REQUEST(
        :I_USER_ID,
        :I_USER_ROLE,
		:I_STATE_CD,
		:O_CUR_REP,
		:O_STATUS,
		:O_MESSAGE
    );
    END;";

    $stid = oci_parse($conn, $query);
    $data = [];

    if ($stid) {
        oci_bind_by_name($stid, ':I_USER_ID',  $reqData["user_id"], 100);
        oci_bind_by_name($stid, ':I_USER_ROLE',  $reqData["user_role"], 100);
        oci_bind_by_name($stid, ':I_STATE_CD',  $reqData["state_cd"], 100);
        oci_bind_by_name($stid, ':O_CUR_REP', $curs, -1, OCI_B_CURSOR);
        oci_bind_by_name($stid, ':O_STATUS',  $O_STATUS, 100);
        oci_bind_by_name($stid, ':O_MESSAGE',  $O_MESSAGE, 100);

        $r = oci_execute($stid);

        if ($r) {

            if ($O_STATUS > 0) {
                oci_execute($curs);
                while (($row = oci_fetch_array($curs, OCI_ASSOC + OCI_RETURN_NULLS)) != false) {
                    array_push($data, $row);
                }
            }
            $responseData = ['status' => $O_STATUS, 'message' => $O_MESSAGE, 'data' => $data];
        } else {
            $e = oci_error($stid);
            $responseData = ['status' => 0, 'message' => $e['message'] . "3"];
        }
    } else {
        $e = oci_error($conn);
        $responseData = ['status' => 0, 'message' => $e['message'] . "4"];
    }
    oci_free_statement($stid);
    oci_free_statement($curs);
    oci_close($conn);
    echo json_encode($responseData);
}

# [8200][07-02-2024 03:34 PM] : for updation of authorization attendance
function authAttendanceRequest($conn, $reqData)
{
    $query = "BEGIN PKGPH_TEST_KKP.PRC_AUTH_ATTND_REQUEST(
        :I_ATND_ID,
        :I_USER_ID,
		:I_USER_ROLE_CD,
		:I_STATE_CD,
		:I_AUTH_CD,
		:I_AUTH_REMARKS,
        :O_STATUS,
        :O_MESSAGE
    );
    END;";

    $stid = oci_parse($conn, $query);

    if (!$stid) {
        $e = oci_error($conn);
        $responseData = array('status' => 0, 'message' => $e['message']);
        echo json_encode($responseData);
        exit;
    }

    oci_bind_by_name($stid, ':I_ATND_ID',  $reqData["atnd_id"], 100);
    oci_bind_by_name($stid, ':I_USER_ID',  $reqData["user_id"], 100);
    oci_bind_by_name($stid, ':I_USER_ROLE_CD',  $reqData["user_role_cd"], 100);
    oci_bind_by_name($stid, ':I_STATE_CD',  $reqData["state_cd"], 100);
    oci_bind_by_name($stid, ':I_AUTH_CD',  $reqData["auth_cd"], 100);
    oci_bind_by_name($stid, ':I_AUTH_REMARKS',  $reqData["auth_remarks"], 100);
    oci_bind_by_name($stid, ':O_STATUS',  $O_STATUS, 100);
    oci_bind_by_name($stid, ':O_MESSAGE',  $O_MESSAGE, 100);

    $r = oci_execute($stid, OCI_NO_AUTO_COMMIT);
    if (!$r) {
        oci_rollback($conn);
        $e = oci_error($stid);
        $responseData = array('status' => 0, 'message' => "2" . $e['message']);
        oci_free_statement($stid);
        oci_close($conn);
        echo json_encode($responseData);
        exit();
    }

    if ($O_STATUS < 1) {
        oci_rollback($conn);
        $responseData = array('status' => $O_STATUS, 'message' => $O_MESSAGE);
        oci_free_statement($stid);
        oci_close($conn);
        echo json_encode($responseData);
        exit();
    }

    $r = oci_commit($conn);
    if (!$r) {
        $e = oci_error($conn);
        $responseData = array('status' => 0, 'message' => "4" . $e['message']);
        oci_free_statement($stid);
        oci_close($conn);
        echo json_encode($responseData);
        exit();
    }

    $responseData = array('status' => $O_STATUS, 'message' => $O_MESSAGE);
    oci_free_statement($stid);
    oci_close($conn);
    echo json_encode($responseData);
}

# [8200][10-02-2024 10:32 PM] : for insertion of attendance request
function insertAttReq($conn, $reqData)
{
    $query = "BEGIN PKGPH_TEST_KKP.PRC_I_ATND_REQUEST(
        :I_ATND_ID,
        :I_USER_ID,
		:I_USER_ROLE_CD,
		:I_STATE_CD,
		:I_USER_REMARKS,
        :O_STATUS,
        :O_MESSAGE
    );
    END;";

    $stid = oci_parse($conn, $query);

    if (!$stid) {
        $e = oci_error($conn);
        $responseData = array('status' => 0, 'message' => $e['message']);
        echo json_encode($responseData);
        exit();
    }

    oci_bind_by_name($stid, ':I_ATND_ID',  $reqData["atnd_id"], 100);
    oci_bind_by_name($stid, ':I_USER_ID',  $reqData["user_id"], 100);
    oci_bind_by_name($stid, ':I_USER_ROLE_CD',  $reqData["user_role_cd"], 100);
    oci_bind_by_name($stid, ':I_STATE_CD',  $reqData["state_cd"], 100);
    oci_bind_by_name($stid, ':I_USER_REMARKS',  $reqData["user_remarks"], 500);
    oci_bind_by_name($stid, ':O_STATUS',  $O_STATUS, 100);
    oci_bind_by_name($stid, ':O_MESSAGE',  $O_MESSAGE, 100);

    $r = oci_execute($stid, OCI_NO_AUTO_COMMIT);
    if (!$r) {
        oci_rollback($conn);
        $e = oci_error($stid);
        $responseData = array('status' => 0, 'message' => "2" . $e['message']);
        oci_free_statement($stid);
        oci_close($conn);
        echo json_encode($responseData);
        exit();
    }

    if ($O_STATUS < 1) {
        oci_rollback($conn);
        $responseData = array('status' => $O_STATUS, 'message' => $O_MESSAGE);
        oci_free_statement($stid);
        oci_close($conn);
        echo json_encode($responseData);
        exit();
    }

    $r = oci_commit($conn);
    if (!$r) {
        $e = oci_error($conn);
        $responseData = array('status' => 0, 'message' => "4" . $e['message']);
        oci_free_statement($stid);
        oci_close($conn);
        echo json_encode($responseData);
        exit();
    }

    $responseData = array('status' => $O_STATUS, 'message' => $O_MESSAGE);
    oci_free_statement($stid);
    oci_close($conn);
    echo json_encode($responseData);
}



# [5376][24-02-2024 01:01 PM] : to get am attendance performance from zm
function getSubordinateAttendanceReport($conn, $reqData)
{

    // ECHO json_encode($reqData);
    // exit;
    $dt = date("Y-m-d", strtotime($reqData["rpt_date"]));
    $user_id = $reqData["user_id"];
    $user_role = $reqData["user_role"];
    $state_cd = $reqData["state_cd"];
    $curs = oci_new_cursor($conn);

    
    
    $query = "BEGIN PKGPH_TEST_KKP.PRC_POPU_USER_PERFORMANCE(
        :I_RPT_DT,          
        :I_USER_ID,        
        :I_USER_ROLE,     
        :I_STATE_CD,      
        :O_CUR_REP,       
        :O_STATUS,        
        :O_MESSAGE
    );       
    END;";


    $stid = oci_parse($conn, $query);
    $data = [];

    if ($stid) {
        oci_bind_by_name($stid, ':I_RPT_DT',  $dt , 100);
        oci_bind_by_name($stid, ':I_USER_ID',  $user_id, 100);
        oci_bind_by_name($stid, ':I_USER_ROLE',  $user_role, 100);
        oci_bind_by_name($stid, ':I_STATE_CD',  $state_cd, 100);
        oci_bind_by_name($stid, ':O_CUR_REP', $curs, -1, OCI_B_CURSOR);
        oci_bind_by_name($stid, ':O_STATUS',  $O_STATUS, 100);
        oci_bind_by_name($stid, ':O_MESSAGE',  $O_MESSAGE, 100);

        $r = oci_execute($stid);

        if ($r) {

            if ($O_STATUS > 0) {
                oci_execute($curs);
                while (($row = oci_fetch_array($curs, OCI_ASSOC + OCI_RETURN_NULLS)) != false) {
                    array_push($data, $row);
                }
            }
            $responseData = ['status' => $O_STATUS, 'message' => $O_MESSAGE, 'data' => $data];
        } else {
            $e = oci_error($stid);
            $responseData = ['status' => 0, 'message' => $e['message'] . "3"];
        }
    } else {
        $e = oci_error($conn);
        $responseData = ['status' => 0, 'message' => $e['message'] . "4"];
    }
    oci_free_statement($stid);
    oci_free_statement($curs);
    oci_close($conn);
    echo json_encode($responseData);
}




