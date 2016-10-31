<?php
if(isset($_GET["from"]) && isset($_GET["addr"]) && $_GET["from"] != "" && $_GET["addr"] != "" && isset($_GET["type"]) && $_GET["type"] == "json"){
	// json.php
	echo file_get_contents("https://www.nicehash.com/api?method=stats.provider.ex&from=".$_GET["from"]."&addr=".$_GET["addr"]);
} else {
	// functions.php
	function pooptitle(){
		$arrayone = array("Mice","Dice","Lice","Slice","Ice","Heist","Rice","Price","Spice","Vice","Thrice","Vise","Gneiss","Splice",);
		$arraytwo = array("Bash","Cash","Sash","Dash","Ash","Brash","Clash","Crash","Cache","Slash","Mash",);

		return $arrayone[rand(0,count($arrayone)-1)]." ".$arraytwo[rand(0,count($arraytwo)-1)];
	}
	function html($str){
		echo($str."\n");
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
	html("</style>");
	html("</head>");
	html("<body'>");
	html("<div style='padding-top: 15%;'>");
	html("<h3>Nice Hash stats kept simple.</h3>");
	if($addrset){
		html("<h4 id=\"addr\">".$_GET["addr"]."</h4>");
		html("<ul id=\"youl\" style=\"list-style: none;\">");
		html("<li>Loading...</li>");
		html("</ul>");
		html("<script>");
		html("window.onload = function(){window.ratedate = 10; checkrate();}");
		html("function getdata(addr){");
		html("	var oReq = new XMLHttpRequest()");
		html("	oReq.addEventListener(\"load\", api)");
		html("	oReq.open(\"GET\", \"/?from=\"+(new Date().getTime() - 60000)+\"&addr=\"+addr+\"&type=json\")");
		html("	oReq.send()");
		html("}");
		html("function checkrate(){");
		html("		if(ratedate < new Date().getTime() - 60000){");
		html("			var oReq = new XMLHttpRequest()");
		html("			oReq.addEventListener(\"load\", function(){");
		html("				var json = JSON.parse(this.responseText)");
		html("				window.exrate = json.USD.last");
		html("				console.log(exrate)");
		html("				ratedate = new Date().getTime()");
		html("				getdata(document.querySelector(\"#addr\").innerHTML)");
		html("			});");
		html("			oReq.open(\"GET\", \"https://blockchain.info/ticker?cors=true\")");
		html("			oReq.send()");
		html("		} else {");
		html("			console.log(\"Used stored rate\")");
		html("			getdata(document.querySelector(\"#addr\").innerHTML)");
		html("		}");
		html("}");
		html("function api(){");
		html("	var json = JSON.parse(this.responseText)");
		html("	console.log(json)");
		html("	if(typeof json['result']['error'] == 'string'){");
		html("		document.querySelector('#youl').innerHTML = \"<li>json['result']['error']</li>\"");
		html("	} else {");
		html("	var algos = json.result.current");
		html("	document.querySelector(\"#youl\").innerHTML = \"\"");
		html("	var unpaid = 0");
		html("	algos.forEach(function(algo, index, arr){");
		html("		if(algo[\"data\"][1] !== '0'){");
		html("			unpaid += parseInt(algo[\"data\"][1])");
		html("		}");
		html("			console.log((algo[\"data\"][1]))");
		html("		if(algo[\"data\"][0][\"a\"]){");
		html("			var profitability = algo[\"data\"][0][\"a\"]*algo[\"profitability\"]");
		html("			console.log(\"Profitability: \"+profitability)");
		// html("			var speed = algo[\"data\"][0][\"a\"] + \" \"+algo[\"suffix\"]");
		html("			document.querySelector(\"#youl\").innerHTML += \"<li>\"+algo[\"name\"]+\": \"+profitability+\" BTC/day | \"+(profitability * exrate).toFixed(2) +\"USD/day | \"+ algo[\"data\"][0][\"a\"] + \" \"+algo[\"suffix\"] +\"/s | \"+unpaid+\"</li>\"");
		html("		}");
		html("		if(index == arr.length -1){");
		html("			console.log('unpaid: '+unpaid)");
		html("			document.querySelector(\"#youl\").innerHTML += \"<li>Unpaid balance: \"+unpaid+\" | \"+(unpaid*exrate).toFixed(2)+\" USD</li>\"");
		html("			var update = setTimeout(checkrate, 20000)");
		html("		}");
		html("	})");
		html("	}");
		html("}");
		html("</script>");
	} else {
		html("<h3>Input your deposit address to see stats</h3>");
		html("<input type='text' id='addrbox' placeholder='Deposit address' />");
		html("<input type='button' value='Go!' id='go' />");
		html("<script>");
		html("document.querySelector('#go').addEventListener('click', gotem)");
		html("function gotem(){");
		html("	console.log('click')");
		html("	window.location='/?addr='+document.querySelector('#addrbox').value ");
		html("}");
		html("</script>");
	}
	html("</div>");
	html("</body>");
	html("</html>");
}
?>