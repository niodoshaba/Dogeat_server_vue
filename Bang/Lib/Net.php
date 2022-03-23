<?php

namespace Bang\Lib;

/**
 * 網路相關功能
 */
class Net {

    /**
     * 
     * @param ServerLoginData $login_data
     * @param type $local_file_path
     * @param type $remote_file_path
     * @return bool 是否上傳成功
     * @throws Exception
     */
    public static function UploadFileToFtp(ServerLoginData $login_data, $local_file_path, $remote_file_path, $ftp_pasv = false, $binary = true) {
        $remote_file = $remote_file_path;   ### 遠端檔案
        $local_file = $local_file_path;   ### 本機儲存檔案名稱
        $handle = fopen($local_file, 'r');
        $conn_id = ftp_connect($login_data->host);
        $login_result = ftp_login($conn_id, $login_data->username, $login_data->password);
        if (!$login_result) {
            throw new Exception("FTP connection authentication fail!", ErrorCode::AuthenticationFail);
        }
        if ($ftp_pasv) {
            ftp_pasv($conn_id, $ftp_pasv);
        }

        $type = $binary ? FTP_BINARY : FTP_ASCII;
        $result = ftp_fput($conn_id, $remote_file, $handle, $type, 0);

        ftp_close($conn_id);
        fclose($handle);
        return $result;
    }

    /**
     * @param string $file_full_name
     * @param string $url
     * @return int size for bytes
     */
    public static function Download($file_full_name, $url) {
        $size_bytes = file_put_contents($file_full_name, fopen($url, 'r'));
        return $size_bytes;
    }

    /**
     * 以Gmail寄送信件
     * @param string $login_email 登入的Email
     * @param string $login_password 登入密碼
     * @param string $subject 信件主旨
     * @param string $from_display_name 檢視送信人名稱
     * @param string $toEmail 收信人Email
     * @param string $html_content 信件內容（Html）
     * @return int 回傳傳送信件成功數
     */
    public static function SendGmail($login_email, $login_password, $subject, $from_display_name, $toEmail, $html_content) {
        require_once Path::Content('Bang/Swiftmailer/swift_required.php');

        $transport = Swift_SmtpTransport::newInstance('smtp.gmail.com', 465, "ssl")
                ->setUsername($login_email)
                ->setPassword($login_password);
        $mailer = Swift_Mailer::newInstance($transport);

        $message = Swift_Message::newInstance($subject)
                ->setFrom(array($login_email => $from_display_name))
                ->setTo(array($toEmail))
                ->setBody($html_content, 'text/html');
        $result = $mailer->send($message);
        return $result;
    }

    /**
     * 將IP轉算為數字
     * @param string $ip_address IP位置
     * @return int 數字結果
     */
    public static function INET_ATON($ip_address) {
        $ip = trim($ip_address);
        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
            return 0;
        }
        return sprintf("%u", ip2long($ip));
    }

    /**
     * 將IPv6轉算為數字長度過長所以是字串（需導入php_gmp 套件）
     * @param string $ip_address IP位置
     * @return int 數字結果
     */
    public static function INET_ATON_V6($ip_address) {
        $ip = trim($ip_address);
        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
            $ip_n = inet_pton($ip);
            $bits = 15; // 16 x 8 bit = 128bit
            $ipv6long = '';
            while ($bits >= 0) {
                $bin = sprintf("%08b", (ord($ip_n[$bits])));
                $ipv6long = $bin . $ipv6long;
                $bits--;
            }
            return gmp_strval(gmp_init($ipv6long, 2), 10);
        } else {
            return 0;
        }
    }

    /**
     * 將數字轉算為IP
     * @param int $ip_number 數字
     * @return string IP位置
     */
    public static function INET_NTOA($ip_number) {
        $num = trim($ip_number);
        if ($num == "0") {
            return "0.0.0.0";
        }
        return long2ip(-(4294967295 - ($num - 1)));
    }

    /**
     * 連結取得HTTP結果內容(POST)
     * @param string $url
     */
    public static function HttpPOST($url, $param, $timeout = 40, $https_keyname = "") {
        $curl = Net::PrepareCurl($url, $https_keyname, $timeout);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $param);

        $recall = curl_exec($curl);
        if (!$recall) {
            return false;
        }
        curl_close($curl);
        return $recall;
    }

    /**
     * 連結取得HTTP結果內容(GET)
     * @param string $url
     */
    public static function HttpGET($url, $https_keyname = "") {
        $curl = Net::PrepareCurl($url, $https_keyname, 25);
        $recall = curl_exec($curl);
        if (!$recall) {
            return false;
        }
        curl_close($curl);
        return $recall;
    }

    /**
     * 準備cURL請求
     * @param string $url 請求網址
     * @param type $https_keyname 是否需要SSL KEY
     * @param type $timeout 請求Timeout秒數
     * @return cURL
     */
    private static function PrepareCurl($url, $https_keyname, $timeout = 40) {
        if (substr($url, 0, 4) != "http") {
            $url = "http://" . $url;
        }
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_ENCODING, "UTF-8");
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $timeout);
        curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        if (substr($url, 0, 5) == "https") {
            curl_setopt($curl, CURLOPT_PORT, 443);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            if ($https_keyname != "") {
                curl_setopt($curl, CURLOPT_SSLCERT, dirname(__FILE__) . "/{$https_keyname}.pem");
                curl_setopt($curl, CURLOPT_SSLKEY, dirname(__FILE__) . "/{$https_keyname}.key");
            }
        }
        return $curl;
    }

    /**
     * 連結取得HTTP結果內容(POST)
     * @param string $url
     */
    public static function HttpPostJson($url, $param, $timeout = 40, $https_keyname = "") {
        $curl = Net::PrepareCurl($url, $https_keyname, $timeout);
        //curl_setopt($curl, CURLOPT_HEADER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Accept: application/json',
            'Content-Type: application/json',
            'Connection: Keep-Alive'
        ));

        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $param);

        $recall = curl_exec($curl);
        if (!$recall) {
            return false;
        }
        curl_close($curl);
        return $recall;
    }

}
