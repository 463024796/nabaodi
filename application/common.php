<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
/* 获取分页的HTML内容
* @param integer $page 当前页
* @param integer $pages 总页数
* @param string $url 跳转url地址    最后的页数以 '&page=x' 追加在url后面
*
* @return string HTML内容;
*/
function getPageHtml($page, $pages, $url)
{
   //最多显示多少个页码
   $_pageNum = 5;
   //当前页面小于1 则为1
   $page = $page < 1 ? 1 : $page;
   //当前页大于总页数 则为总页数
   $page = $page > $pages ? $pages : $page;
   //页数小当前页 则为当前页
   $pages = $pages < $page ? $page : $pages;
   //计算开始页
   $_start = $page - floor($_pageNum / 2);
   $_start = $_start < 1 ? 1 : $_start;
   //计算结束页
   $_end = $page + floor($_pageNum / 2);
   $_end = $_end > $pages ? $pages : $_end;

   //当前显示的页码个数不够最大页码数，在进行左右调整
   $_curPageNum = $_end - $_start + 1;
   //左调整
   if ($_curPageNum < $_pageNum && $_start > 1) {
       $_start = $_start - ($_pageNum - $_curPageNum);
       $_start = $_start < 1 ? 1 : $_start;
       $_curPageNum = $_end - $_start + 1;
   }
   //右边调整
   if ($_curPageNum < $_pageNum && $_end < $pages) {
       $_end = $_end + floor($_pageNum - $_curPageNum);
       $_end = $_end > $pages ? $pages : $_end;
   }

   $_pageHtml = '<ul class="pagination">';
   /*if($_start == 1){
   $_pageHtml .= '<li><a title="第一页">«</a></li>';
   }else{
   $_pageHtml .= '<li><a  title="第一页" href="'.$url.'&page=1">«</a></li>';
   }*/
   if ($page > 1) {
       $_pageHtml .= '<li><a  title="上一页" href="' . $url . '&page=' . ($page - 1) . '">«</a></li>';
   }
   for ($i = $_start; $i <= $_end; $i++) {
       if ($i == $page) {
           $_pageHtml .= '<li class="active"><a>' . $i . '</a></li>';
       } else {
           $_pageHtml .= '<li><a href="' . $url . '&page=' . $i . '">' . $i . '</a></li>';
       }
   }
   /*if($_end == $pages){
   $_pageHtml .= '<li><a title="最后一页">»</a></li>';
   }else{
   $_pageHtml .= '<li><a  title="最后一页" href="'.$url.'&page='.$pages.'">»</a></li>';
   }*/
   if ($page < $_end) {
       $_pageHtml .= '<li><a  title="下一页" href="' . $url . '&page=' . ($page + 1) . '">»</a></li>';
   }
   $_pageHtml .= '</ul>';
   return $_pageHtml;
}
/**
 * 是否存在方法
 * @param string $module 模块
 * @param string $controller 待判定控制器名
 * @param string $action 待判定控制器名
 * @return number 方法结果，0不存在控制器 1存在控制器但是不存在方法 2存在控制和方法
 */
function has_action($module,$controller,$action)
{
    $arr=\ReadClass::readDir(__DIR__ . $module. '/' .'controller');
    if((!empty($arr[$controller])) && $arr[$controller]['class_name']==$controller ){
		$method_name=array_map('array_shift',$arr[$controller]['method']);
        if(in_array($action, $method_name)){
           return 2;
        }else{
           return 1;
        }
    }else{
        return 0;
    }
}
