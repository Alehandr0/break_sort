<?/*

MIT License

Copyright (c) 2016 Tovstoles Aleksandr - fb.com/Tovstoles

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.

///*///

define("ZOOM", 16);

function breakSort(&$a)
{
	$n=count($a);

	for($i=$n-1; $i>0; $i--)
	{
		if ($a[$i] < $a[$i - 1])
		{
			$x = $a[$i];
			$a[$i] = $a[$i - 1];
			$a[$i - 1] = $x;
		}
	}
	for($i=2; $i<$n; $i++)
	{
		if ($a[$i] < $a[$i - 1])
		{
			$x = $a[$i];
			$a[$i] = $a[$i - 1];
			$a[$i - 1] = $x;
		}
		$a[$i - 1] -= $a[0];
	}
	$a[$n - 1] -= $a[0];

	$b = $a[$n - 1] / ZOOM;
	$c=array(1+$b);
	for($i=0; $i<$b; $c[$i]=0, $i++){}
	$c[0] = 1;
	$c[1] = 1;
	for($i=1; $i<$n; $i++)
	{
		$d = 1 + floor($a[$i] / ZOOM);
		0==$c[$d]&&$c[$d]=1;
	}
	$e = 0;
	for($i=1, $z=$b+1; $i<$z; $i++)
	{
		if ($c[$i] == 0 && $c[$i - 1] == 1) $e++;
	}
	$e++;
	$f=array(1+$e);
	for($i=0; $i<$e; $f[$i]=0, $i++){}
	$f[0] = ZOOM;
	$f[$e] = $b;
	$g=array($e);
	for($i=0; $i<$e; $g[$i]=0, $i++){}
	$h = 1;
	$m = 1 + $b;
	for($i=1; $i<=$m; $i++)
	{
		if ($c[$i] == 0 && $c[$i - 1] == 1)
		{
			$f[$h] = $i - 2;
			$h++;
		}
	}
	$h = 1;
	for($i=1; $i<=$m; $i++)
	{
		if ($c[$i] == 1 && $c[$i - 1] == 0)
		{
			$g[$h] = $i;
			$h++;
		}
	}
	for($i=1; $i<$e; $i++)
	{
		$f[$i] = $f[0] * $f[$i];
	}
	for($i=1; $i<$e; $i++)
	{
		$g[$i] = $f[0] * $g[$i] - 1;
	}
	$f[$e] = $a[$n - 1];
	$o=array(1+$e);
	for($i=1; $i<$n; $i++)
	{
		for($k=1; $k<$e; $k++)
		{
			if ($a[$i] > $f[$k] && $a[$i] < $f[$k] + $f[0])
			{
				$f[$k] = $a[$i];
				break;
			}
		}
		for($k=1; $k<$e; $k++)
		{
			if ($a[$i] < $g[$k] && $a[$i] > $g[$k] - $f[0])
			{
				$g[$k] = $a[$i];
				break;
			}
		}
	}
	$o[0] = 0;
	for($i = 1; $i <= $e; $i++)
	{
		$o[$i] = 1 + $f[$i] - $g[$i - 1];
		$o[0] += $o[$i];
	}
	$q=array(1+$o[0]);
	for($i=0, $z=$o[0]+1; $i<$z; $q[$i]=0, $i++){}
	$q[1] = 1;
	for($i=1; $i<$n; $i++)
	{
		$h = 0;
		for($k = 1; $k <= $e; $k++)
		{
			if ($g[$k - 1] <= $a[$i] && $a[$i] <= $f[$k])
			{
				$m = $a[$i] - $g[$k - 1] + $h + 1;
				$q[$m]++;
				break;
			}
			$h += $o[$k];
		}
	}
	$x = 0;
	$h = 0;
	$m = - 1;
	for($i=1; $i<=$e; $i++)
	{
		if ($i > 1) $x += $o[$i - 1];
		for($j=1; $j<=$o[$i]; $j++)
		{
			$h++;
			for($k=1; $k<=$q[$h]; $k++)
			{
				$m++;
				$a[$m] = $a[0] + $g[$i - 1] + $h - $x - 1;
			}
		}
	}
}

///*///
