<!-- Rebecca Jahnke
	 Receives form data (gross income) from form.php and calculates progressive 
	 income tax and effective tax rate, displaying results back to user as 
	 HTML 5 output--> 
<?php
	$grossIncome = filter_input(INPUT_POST, 'grossIncome',
        FILTER_VALIDATE_FLOAT);

    // validate grossIncome
    if ($grossIncome === FALSE ) {
        $error_message = 'Investment must be a valid number.'; 
    }
    else if ($grossIncome < 10000 ) {
        $error_message = 'Investment must be at least or greater than $10,000.'; 
    }
    // set error message to empty string if no invalid entries
    else {
        $error_message = ''; 
    }

     // if an error message exists, go to the form page
    if ($error_message != '') {
        include('form.php');
        exit(); 
    }

    // calculations 

    // calculate taxable income, which is gross income minus 10,000
	$taxableIncome = $grossIncome - 10000;

	/* use conditionals to decide tax rate, perform computation to get
	total income tax */
	if ($taxableIncome <= 9225) {
		$totalIncomeTax = ($taxableIncome * 10) / 100;
	}
	elseif ($taxableIncome >= 9226 && $taxableIncome <= 37450) {
		$totalIncomeTax = ((($taxableIncome - 9225) * 15) / 100) + 922.50;
	}
	elseif ($taxableIncome >= 37451 && $taxableIncome <= 90750) {
		$totalIncomeTax = ((($taxableIncome - 37450) * 25) / 100) + 5156.25;
	}
	elseif ($taxableIncome >= 90751 && $taxableIncome <= 189300) {
		$totalIncomeTax = ((($taxableIncome - 90750) * 28) / 100) + 18481.25; 
	}
	elseif ($taxableIncome >= 189301 && $taxableIncome <= 411500) {
		$totalIncomeTax = ((($taxableIncome - 189300) * 33) / 100) + 46075.25;
	}
	elseif($taxableIncome >= 411501 && $taxableIncome <= 413200) {
		$totalIncomeTax = ((($taxableIncome - 411500) * 35) / 100) + 119401.25; 
	}
	else { // $taxableIncome >= 413201
		$totalIncomeTax = ((($taxableIncome - 413200) * 39.6) / 100) + 119996.25;
	}

	// calculate effectiveTaxRate and store 
	$effectiveTaxRate = $totalIncomeTax / $grossIncome;
	$effectiveTaxRate *= 100;
	$effectiveTaxRate = round($effectiveTaxRate, 1); //round to 1 place after decimal

    // apply formatting

	$grossIncome_f = number_format($grossIncome);
	$taxableIncome_f = number_format($taxableIncome);
	$totalIncomeTax_f = number_format($totalIncomeTax, 2);
?>

<!DOCTYPE html>
<html>
<head> 
	<meta charset="utf-8" />
	<title> Progressive Income Tax </title>
	<link rel="stylesheet" type="text/css" href="main.css">
</head>
<body>
	<main> 
		<h1> Progressive Income Tax Calculator </h1> 
		<?php
		echo "As a single taxpayer with a gross annual income of $" . $grossIncome_f
			 . ", your taxable income is $" . $taxableIncome_f . ".";
			
		$newline = "\n";     // create a newline in php with these 2 lines
		echo nl2br($newline);
		$newline = "\n";     // creating another newline 
		echo nl2br($newline);
			
		echo "Your total income tax is $" . $totalIncomeTax_f . " (" . $effectiveTaxRate
			 . "% effective tax rate).";
	    ?>
	</main>
</body>
</html>
