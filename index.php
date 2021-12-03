<?php
class Permuting 
{
	private $arr;
	private $arr_key;
	private $leng; 
	private $m;

	function __construct($str, $m)
	{
		$arr = str_split($str);
		$this->arr = $arr;
		$leng = count($arr);
		$this->leng = $leng;
		for ($i = 0; $i < $this->leng; $i++)
		{
			$this->arr_key[$i] = $i;
		}
		$this->m = $m;
	}
	function comparison($arr1, $arr2, $leng) // проверка на схожесть массивов по всем параметрам 
	{
	    $flag = true;
	    for ($i = 0; $i < $leng; $i++)
	    {
	        if ($arr1[$i] != $arr2[$i]) 
	        {
	            $flag = false;
	        }
	    }
	    return $flag;
	}
	function brute_force($arr, $first, $last) /// изменение местами двух элементов массива
	{
	    $elem = $arr[$first];
	    $arr[$first] = $arr[$last];
	    $arr[$last] = $elem;
	    return $arr;
	}
	function fact ($leng) // расчет факториала числа
	{
	 	$factorial = 1; 
		for ($i = 1; $i <= $leng; $i++)
		{
			$factorial *= $i;
		}
		return $factorial;
	}
	function col () // расчет числа возможных размещений 
	{
		if ($this->leng == 1) {return 1;} 
    	$res = $this->fact($this->leng)/$this->fact($this->leng - $this->m);
    	return $res;
	}
	function Permutation($permut, $res, $flag = true) // генерация размещений 
 	{
	    $element_arr = array();
	    for ($i = 0; $i < $this->m; $i++)
	    {
	        $element_arr[$i] = $res[$i];
	    }
	    $permut[] = $element_arr;
	    if ($this->col($this->leng, $this->m) != count($permut))
	    {
	        if ($this->leng == $this->m && $this->m != 1)
	        {
	            $k = $this->m - 1;
	        }
	        else 
	        {
	            $k = $this->m;
	        }
	        for ($i = 0; $i < $k; $i++)
	        {
	            $r = $res[$i];
	            unset ($res[$i]);
	            array_push($res, $r);
	        }
	        $auto_key = 0;
	        $auto_arr = array();
	        foreach ($res as $value)
	        {
	            $auto_arr[$auto_key] = $value;
	            $auto_key++;
	        }
	        $res = $auto_arr;
	        if ($this->comparison($res, $this->arr_key, $this->leng) == false)
	        {
	            $new_permut = $permut;
	            $new_res = $res;
	            $this->Permutation($new_permut, $new_res, $flag);
	        }
	        else
	        {
	            if ($flag == true)
	            {
	                $new_res = array_reverse ($res);
	                $new_arr_key = array_reverse($this->arr_key);
	                $this->arr_key = $new_arr_key;
	                $flag = false;
	                $new_permut = $permut;
	                $this->Permutation($new_permut, $new_res, $flag = false);
	            }
	            else 
	            {
	                $brute_flag = true;
	                for ($i = 0; $i < $this->leng; $i++)
	                {
	                    for ($j = 1; $j < $this->leng; $j++)
	                    {
	                        $unseted = $this->brute_force($res, $i, $j);
	                        $unseted_arr = array();
	                        for ($l = 0; $l < $this->m; $l++)
	                        {
	                            $unseted_arr[$l] = $unseted[$l];
	                        }
	                        foreach ($permut as $arr)
	                        {
	                            $chek_unseted = 0;
	                            for ($k = 0; $k < count($arr); $k++)
	                            {
	                                if ($arr[$k] == $unseted_arr[$k]) $chek_unseted++;
	                            }
	                            if ($chek_unseted == count($arr))
	                            {
	                                $brute_flag = false; 
	                                break;
	                            }
	                            $brute_flag = true;
	                        }
	                        if ($brute_flag == true)
	                        {
	                            $first = $i;
	                            $last = $j;
	                            break;
	                        }
	                    }
	                    if ($brute_flag == true) { break; }
	                }
	                $res = $this->brute_force($res, $first, $last);
	                $this->arr_key = $this->brute_force($this->arr_key, $first, $last);

	                
	                $flag = true;
	                $new_permut = $permut;
	                $new_res = $res;

	                $this->Permutation($new_permut, $new_res, $flag);
	            }
	        }
	    }
	    else 
	    {
	        $col_permut = $this->col();
	        echo "Количество размещений без повторений - $col_permut";
	        $final = $permut;
	        echo "<br>";
	        foreach ($permut as &$arr)
	        {
	            foreach ($arr as &$value)
	            {
	                $value = $this->arr[$value];
	            }
	            print_r ($arr);
	            echo "<br>";
	        }
	        die ();
	    }
  	}
  	function show () 
  	{
  		$res = $this->arr_key;
  		$this->Permutation($permut = array(), $res, $flag = true);
  	}
	function __destruct()
	{
		echo "конец работы";
	}
}

 /// исходные данные
$n = "111";
$m = 2; 


if ($n < $m || is_string($n) == false || $m <= 0 || is_int($m) == false || strlen($n) == 0) 
	{ die("Неверно введены исходные данные"); }

$perm = new Permuting($n, $m);
$perm -> show();

?>