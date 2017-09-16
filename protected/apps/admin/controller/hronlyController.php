<?php
class hronlyController extends commonController{

    public  $map = null;

    public function __construct()
    {
        parent::__construct();
        $this->map = $this->getmap();
        $this->__set('map',$this->map);

    }

    public function index(){

        $contentArray['subjectName'] = optionValues(model('subjectDetail')->select("tid='0'"),'subjectName','--请选择--');

        $this->assign('contentArray',$contentArray);

        /*$this->assign('req',$req);*/
        $this->display();

}

    public function ajaxReturn(){

        $query = in($_GET['query']);
        $field = in($_GET['value']);

        session_starts();


        switch($query){

            case 'subjectName':
                $field = in($_GET['subjectName']);
                if(!empty($field)){

                    $info = model('subjectDetail')->find(" `subjectName` ='$field' ");

                    if($info){echo json_encode( array('valid'=>false));exit;}
                    else{echo json_encode( array('valid'=>true));}}
                break;

            default:

        }

    }

    public function download(){

        $dateNow = date("Ymd-His");
        $filename="$dateNow.txt";

        $content = $this->getEstimateContentByTerm();

        $encoded_filename = urlencode($filename);
        $filename = $encoded_filename = str_replace("+", "%20", $encoded_filename);


        $chars = $content; //需要导出的文件的内容
        header('Content-Type: text/x-sql');
        header('Expires: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Content-Disposition: attachment; filename="' .$filename. '"');
        header('Pragma: no-cache');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');

        echo $chars;

        exit();

    }

    public function getEstimateContentByTerm(){


        /*$sql = "select * from estimate_history";*/


        $startTime = in($_GET['startTime']);
        $endTime = in($_GET['endTime']);



        $subjectName = in($_GET['subjectName']);
        if(empty($subjectName)){echo"error!请先选择学院";exit;}

        $where['id'] = $subjectTeacherName = in($_GET['subjectTeacherName']);

        if(!empty($subjectTeacherName) and $subjectTeacherName!='nodata'){

            $realName = model('subjectDetail')->find($where);
            $subjectTeacherName = $realName['subjectTeacherName'];
            $subjectTeacherName = "and teacherName='$subjectTeacherName'";


        }
        else{
            $subjectTeacherName = '';
        }

        $contentInfo = model('user')->model->query("select * from estimate_history where sid='$subjectName' $subjectTeacherName and `setting_time` >= '$startTime' and `setting_time` <= '$endTime'");


        if(empty($contentInfo)){echo "no content!!";exit;}

        $content = '';
        foreach($contentInfo as $value){

            $content .= $value['content'];

        }

        return $content;

    }

}