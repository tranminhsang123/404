<!-- ----BIẾN TRONG PHP 
1 biến trong php là cái tên của vị trí bộ nhớ chứa dữ liệu . biến là bộ nhớ tạm thời được sử dụng để lưu trữ dữ liệu tạm thời 
cú pháp: $ten_bien 
ví dụ: $nick
chú ý 
- tên biến trong php phải bắt đầu bằng chữ cái hoặc gạch chân dưới 
- tên biến trong php được phép chứa chữ cái chữ số gách chân
- tên biến trong php không được phép chứa các kí tự đặc biệt
- khi đặt tên biến không cần khai báo kiểu dữ liệu 
- nên đặt tên theo quy chuẩn camelcase
gán biến: $tên_biên = giá trị ;
xuất dữ liệu : echo " tên biến, tên hàm, chuỗi, số";  -->
<?php
$nick = "nick final ";
echo "$nick";

?>
<br>
<!-- 
comment và debug dữ liệu 
comment: là các câu lệnh không được thực hiện trong quá trình chạy chương trình
cú pháp: // comment
/* comment */
debug: là các câu lệnh được sử dụng để kiểm tra dữ liệu trong quá trình chạy chương trình
cú pháp: var_dump(); print_r(); echo; -->
<?php
$nick = "trần minh sang"; // đặt tên biến 
echo $nick; // xuất dữ liệu 
?>
<br>
<!-- nối biến // nối biến bằng dấu chấm
cú pháp : $bienso1.$bienso2; -->
<?php 
$nick = "nick final ";
$age = "20";
$hienthi = $nick.$age;
echo $hienthi;
?>
<br>

<!-- khai báo và sử dụng hằng số
hằng số trong php là tên hoặc mã định danh không thể thay đổi trong khi thực hiện chương trình
các hằng số trong php có thể định nghĩa theo 2 cách 
1. khai báo hằng số bằng cách sử dụng từ khóa const
2. khai báo hằng số bằng cách sử dụng hàm define()
cú pháp: const tên_hằng = giá trị ;
cú pháp: define("tên_hằng", giá trị);
sử dụng ten_hang
đặt tên hằng
chứa cái chữ cái chữ số gạch chân
bắt đầu bằng chữ cái hoặc gạch chân
phân biệt chữ hoa chữ thường 
 -->
<?php
define('_nick',002);
echo "_nick";
?>


<br>

<!-- 
kiểu int
kiểu số thực 
kiểu string chuỗi
kiểu boolean 
kiểu mảng
kiểu null  -->
<?php



