<?php
if(isset($_GET["addr"]) && $_GET["addr"] != "" && isset($_GET["type"]) && $_GET["type"] == "json"){
	// json.php
		echo "{ \"nh\":".file_get_contents("https://www.nicehash.com/api?method=stats.provider.ex&from=".$_GET["from"]."&addr=".$_GET["addr"]).", \"md5\":\"".md5(fread(fopen(__FILE__, "r"), 1048576))."\", \"under_construction\": ".((time() - filemtime(__FILE__)) < (21600 + 15*60) ? 1 : 0)."}";
} else {
	// functions.php
	function pooptitle(){
		$arrayone = array("Mice","Dice","Lice","Slice","Ice","Heist","Rice","Price","Spice","Vice","Thrice","Vise","Gneiss","Splice",);
		$arraytwo = array("Bash","Cash","Sash","Dash","Ash","Brash","Clash","Crash","Cache","Slash","Mash",);
		return $arrayone[rand(0,count($arrayone)-1)]." ".$arraytwo[rand(0,count($arraytwo)-1)];
	}
	function html($str){
		if(false){
			echo(trim($str));
		} else {
			echo($str."\n");
		}
	}
	// index.php
	if(isset($_GET["addr"]) && $_GET["addr"] != ""){
		$addrset = true;
	} else {
		$addrset = false;
	}
	html("<!DOCTYPE html>");
	html("<html style='text-align: center;'>");
	html("<head>");
	html("	<title>".pooptitle()."</title>");
	html("<style>");
	html("	.progress-bar{");
	html("		background-color:#757575;");
	html("		height:100%;");
	html("		position:absolute;");
	html("		line-height:inherit;");
	html("	}");
	html("	.progress-container{");
	html("		width:100%;");
	html("		height:1.5em;");
	html("		position:relative;");
	html("		background-color:#f1f1f1");
	html("	}");
	html("	.hidden{");
	html("		visibility: hidden;");
	html("	}");
	html("</style>");
	html("</head>");
	html("<body>");
	html("<img id='under_construction' src='https://upload.wikimedia.org/wikipedia/en/1/1d/Page_Under_Construction.png' style='height:10vw; width:20vw;' class='hidden'></img>");
	html("<div style='padding-top: 0%;'>");
	html("<h3>Nice Hash stats kept simple.</h3>");
	if($addrset){
		html("<h4 id=\"addr\">".$_GET["addr"]."</h4>");
		html("<table style='margin: auto;'>");
		html("<th>Algorithm</th>");
		html("<th>Profitability (BTC)</th>");
		html("<th>Profitability (USD)</th>");
		html("<th>Speed</th>");
		html("<tbody id='youl'>");
		html("</tbody>");
		html("</table>");
		html("<p id='unpaid' style='margin: 0px 0px 0px 0px;'>Loading...</p>");
		html("<table style='margin: auto;'>");
		html("<th>Amount(BTC)</th>");
		html("<th>Amount(USD)</th>");
		html("<th>Time</th>");
		html("<tbody id='paymentsbox'>");
		html("</tbody>");
		html("</table>");
		html("<script>");
		html("window.onload = function(){window.ratedate = 10; checkrate();};");
		html("function getdata(addr){");
		html("	var oReq = new XMLHttpRequest();");
		html("	oReq.addEventListener(\"load\", function(){dontdoonlytry(this.responseText)});");
		html("	oReq.open(\"GET\", '".$_SERVER['PHP_SELF']."'+\"/?from=0&addr=\"+addr+\"&type=json\");");
		html("	oReq.send();");
		html("}");
		html("function checkrate(){");
		html("		if(ratedate < new Date().getTime() - 60000){");
		html("			var oReq = new XMLHttpRequest();");
		html("			oReq.addEventListener(\"load\", function(){");
		html("				var json = JSON.parse(this.responseText);");
		html("				window.exrate = json.USD.last;");
		html("				ratedate = new Date().getTime();");
		html("				getdata(document.querySelector(\"#addr\").innerHTML);");
		html("			});");
		html("			oReq.open(\"GET\", \"https://blockchain.info/ticker?cors=true\");");
		html("			oReq.send();");
		html("		} else {");
		html("			getdata(document.querySelector(\"#addr\").innerHTML);");
		html("		}");
		html("}");
		html("function dontdoonlytry(data){"); // You're right, this was added as an after thought
		html("	try{");
		html("		api(data);");
		html("	}");
		html("	catch(err){");
		html("		if(err){");
		html("			console.log(err);");
		html("			console.log('Ouch!');");
		html("			setTimeout(dontdoonlytry, 5000);");
		html("		}");
		html("	}");
		html("}");
		html("var mdfive;");
		html("function api(data){");
		html("	var text = JSON.parse(data);");
		html("	var json = text.nh;");
		html("	if(!mdfive){");
		html("		mdfive = text.md5;");
		html("	} else {");
		html("		if(mdfive !== text.md5){");
		html("			window.location.reload();");
		html("		}");
		html("	}");
		html("	document.querySelector('#under_construction').setAttribute('class', (text.under_construction ? '' : 'hidden')); ");
		html("	var totalprofitability = 0;");
		html("	if(typeof json['result']['error'] == 'string'){");
		html("		document.querySelector('#youl').innerHTML = \"<li>json['result']['error']</li>\";");
		html("	} else {");
		html("	var algos = json.result.current;");
		html("	document.querySelector(\"#youl\").innerHTML = \"\";");
		html("	var unpaid = 0;");
		html("	algos.forEach(function(algo, index, arr){");
		html("		if(algo[\"data\"][1] !== '0'){");
		html("			unpaid += parseFloat(algo[\"data\"][1]);");
		html("		}");
		html("		if(algo[\"data\"][0][\"a\"]){");
		html("			var profitability = algo[\"data\"][0][\"a\"]*algo[\"profitability\"];");
		html("			totalprofitability += profitability;");
		html("			document.querySelector(\"#youl\").innerHTML += \"<tr><td>\"+algo[\"name\"]+\"</td><td>\"+profitability.toFixed(6)+\" BTC/day</td><td>\"+(profitability * exrate).toFixed(2) +\" USD/day</td><td>\"+ algo[\"data\"][0][\"a\"] + \" \"+algo[\"suffix\"] +\"/s</td></tr>\";");
		html("		}");
		html("		if(index == arr.length -1){");
		html("			document.querySelector(\"#youl\").innerHTML += '<tr><td>Total</td><td>'+totalprofitability.toFixed(8)+' BTC/day</td><td>'+(totalprofitability*exrate).toFixed(2)+' USD/day</td><td></td></tr>';");
		html("			document.querySelector(\"#unpaid\").innerHTML = \"Unpaid balance: \"+unpaid.toFixed(8)+\" | \"+(unpaid*exrate).toFixed(2)+\" USD\";");
		html("			var update = setTimeout(checkrate, 30000);");
		html("		}");
		html("	});");
		html("		document.querySelector('#paymentsbox').innerHTML = '';");
		html("		console.log(new Date().toDateString()+' '+new Date().toLocaleTimeString());");
		html("		json['result']['payments'].forEach(function(val, ind, arr){");
		html("			this.innerHTML += '<tr><td>'+(val.amount)+'</td><td>'+(val.amount*exrate).toFixed(2)+'</td><td>'+(new Date(val.time*1000)).toDateString()+' '+new Date(val.time*1000).toLocaleTimeString()+'</td></tr>';");;
		html("		}, document.querySelector('#paymentsbox'));");
		html("	}");
		html("}");
		html("</script>");
	} else {
		html("<h3>Input your deposit address to see stats</h3>");
		html("<form id='firm' onsubmit='return false;'>");
		html("<input type='text' id='addrbox' placeholder='Deposit address' />");
		html("<input type='button' value='Go!' id='go' />");
		html("</form>");
		html("<script>");
		html("document.querySelector('#firm').addEventListener('submit', gotem);");
		html("document.querySelector('#go').addEventListener('click', gotem);");
		html("function gotem(){");
		html("	window.location=window.location + '?addr='+document.querySelector('#addrbox').value;");
		html("}");
		html("</script>");
	}
	html("</div>");
	html("</body>");
	html("</html>");
}
?>