<!-- vòng lặp for
cú pháp:
for($ten_bien= giá trị đầu; điều kiện dừng : biểu thức tăng giảm){
	// câu lệnh
ví dụ 
for($nick = 0; $nick < 10; $nick++){
	echo $nick.'<br>';
} -->





<!-- bài tập vòng lặp for
bài 1: 
hiển thị số chẳn số lẻ trong dãy số từ 1 2 3 4 5 .. 100
giải  -->

<?php
$start = 1;
$end = 100;
$diemsole = 0; // đếm số lẻ 
$diemsochan = 0; // đếm số chẳn 
$resultsole = null; // biến lưu số lẻ 
$resultsochan = null; // biến lưu số chẳn

for ($i = $start; $i <= $end ; $i++) {
    // kiem tra so chan so le %
    if($i % 2 == 0 ){
        // $i là số chẳn 
        $resultsochan .=$i . " ";
        $diemsochan++;
    }else{
        // $i là số lẻ 
        $resultsole .=$i . " ";
        $diemsole++;
    }
}

if($diemsochan > 0 ){
    echo " tìm thấy: " .$diemsochan. "số chẳn là : $resultsochan ";  
}else{
    echo " khong có số chẳn ";
}

echo "<br>";

if($diemsole > 0 ){
    echo " tìm thấy: " .$diemsole. "số lẻ là : $resultsole ";  
}else{
    echo " khong có số lẻ ";
}


// bài tập số 2 
// tính giai thừa của 1 số nhập vào và hiện kết quả 
// giải thích 
// input : nhập vào số n 
// output : hiển thị kết quả n
// công thức : N! = 1*2*3...*N (N>0)
echo "<br>";
$n = 10;
if($n > 0){
    // xử lý tính giải thừa 
    $result = 1; // biến kết quả 
    for($i =1; $i <= $n ; $i++){
        $result *= $i;
    }
    echo "kết quả giai thừa là :" .$result . " ";
}



?>
