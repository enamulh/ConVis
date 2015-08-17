<!DOCTYPE html>
<?php
session_start();
// store session data
$_SESSION['views']=100;
?>
<html>
	
    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
        <link rel="stylesheet" type="text/css" href="style_simple.css">	
        <script src="js/d3.js"></script>
        <script src="js/jquery.js"></script>
        <script type="text/javascript" src="js/jquery_002.js"></script>
        <script type="text/javascript" src="js/jquery_003.js"></script>		
        <script type="text/javascript" src="js/init.js"></script>		
        <script type="text/javascript" src="js/jcollapsible.js"></script>

        <script type="text/javascript" src="js/commentview_baseline.js"></script>
        <script type="text/javascript" src="js/search.js"></script>		
		<script src="js/highlight.js" type="text/javascript"></script>
        <script></script>	
    </head>
    <body>
        <table cellspacing="0" align="left">
			<tr align="left">
							<td align="left">
			<table cellspacing="0" align="left">
			<td align="left">
				<div id="div_search"  align="left">Search:
					<!--<form id="tfnewsearch" method="get" action="javascript:search()">-->
							<!--<input type="text" id="search" class="tftextinput3" size="25" maxlength="120" value="Search" onblur="highlightme()" >-->
							        <input type="text" name="search" id="search" onblur="highlightme()" align="left"/>
							<span class="result-count" ></span>
					<!--</form>-->	
					<div class="tfclear" align="left"></div>
				 </div>	
				 </td>
				 <td width=25 >
				<div  id="logout" onclick="logout()" title="Finish task and logout"> 	
				
						<img src="icons/logout.png" height=20 width=18><a href="" ></a>
				 </div>	</td>
			</table>	 
				 </td>
			</tr>
            <tr align="left">
                <td align="left" style="display: none;">
                    <div id="chart" align="left" style="display: none;">
		 
	  			
                        <script>
	filename="";				
	interfaceName="A";
	logInteraction("Start");
	function logInteraction(str)
	{
		str=interfaceName+","+jsonFileMainView+","+str;
		//alert(str);
		if (str=="") {
		  document.getElementById("txtHint").innerHTML="";
		  return;
		}
		if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
		  xmlhttp=new XMLHttpRequest();
		}
		else {// code for IE6, IE5
		  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		  }
		xmlhttp.onreadystatechange=function()
		  {
		  if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
			}
		  }
		xmlhttp.open("GET","do_query.php?q="+str,true);
		xmlhttp.send();
	}
					 $("#search").keyup(function(event){
						if(event.keyCode == 13){
							highlightme();
						}
					 });
					 function highlightme()
					 {
						//setTimeout(performSearch, 300);
						//alert("test");
						//function performSearch() {
							var str=document.getElementById('search').value;
							if(str==""){
								$('#content').removeHighlight(); return;}
							else if (str.length < 3) { return;}
							var strarray=str.split(" ");
							void($('#content').removeHighlight().highlight(strarray)); //pass string array to function
						//}
					 }

		window.onload = function(){ 
			//Get submit button
			var submitbutton = document.getElementById("search");
			//Add listener to submit button
			if(submitbutton.addEventListener){
				submitbutton.addEventListener("click", function() {
					if (submitbutton.value == 'Search'){//Customize this text string to whatever you want
						submitbutton.value = '';
					}
				});
			}
			
		}

// Possible color families
/*colorFamily = [
    ["241,89,95", "121,195,106", "89,154,211", "249,166,90", "158,102,171"],
    ["205,112,88", "89,154,211", "241,89,95", "215,127,179", "121,195,106", "230, 171, 2"],
    ["205,112,88", "89,154,211", "121,195,106", "158,102,171", "241,89,95"],
    ["241, 89,95", "121,195,106", "249,166,90", "215,127,179", "205,112,88"],
    ["249,166,90", "205,112,88", "89,154,211", "215,127,179", "121,195,106"],
    ["205,112,88", "121,195,106", "215,127,179", "89,154,211", "241, 89,95"]
];*/

/*sentimentColors = [
    "215, 25, 28",
    //"253, 174, 97",
    "239, 165, 165",
    "255, 255, 191",
    "166, 217, 106",
    "26, 150, 65"
];*/
//purple- orange
sentimentColors = [
    "230, 97, 1",
    "253, 184, 99",
    "240, 240, 240",	 
    //"178, 171, 210",
	"170, 163, 205",
    //"94, 60, 153"
	"125,87,189"
];

topicColor="rgb(0, 71, 157)";
authorColor= "rgb(152, 78, 163)";	
topicClickColor="rgb(179,200,226)";
authorClickColor="rgb(224,202,227)";

//pink-green
/*sentimentColors = [
    "208, 28, 139",
    "241, 182, 218",
    "247, 247, 247",
    "184, 225, 134",
    "77, 172, 38"
];*/

var w = 900,
        h = 780,
        i = 0,
        barHeight = 0,
        barWidth = w * .23,
        duration = 400,
        root,
        minimumbarHeight = 5,
        maximumbarHeight = 30;

var arcRad = 250, arcCx = barWidth / 2, arcCy = 200, angleInDegrees = 15;
var radius = 5, gap = 50;
var indentation=40;
var spaceforFacetSelector=7;

var tree = d3.layout.tree()
        .size([h, indentation]);

var diagonal = d3.svg.diagonal()
        .projection(function(d) {
    return [d.y, d.x];
});

var topicDiagonal = d3.svg.diagonal()
        .projection(function(d) {
    return [d.y, d.x];
});

/* var vis = d3.select("#chart").append("svg:svg")
        .attr("width", w)
        .attr("height", h)
        .append("svg:g")
        .attr("transform", "translate(330,0)");
 */		 
/* var rect = vis.append("rect")
    .attr("width", "100%")
	.attr("opacity", "0")	
	.attr("stroke","rgb(0,0,0)")
    .attr("height", "100%")
	.attr("transform", "translate(-330,0)")
    .on("click", mouseclick);
 */
topicList = [];
d3.json(jsonFileMainView, function(json) {
    root = json;
	nodes = tree.nodes(root);	
	$( "#div_title" ).append( root.title+"\t("+nodes.length+" comments)");
	
	for (j = 0; j < root.topics.length; j++) {
        var topicLabel = root.topics[j].labels[0].phrase;
        //alert(fontSize);

        topicList.push({topicID: root.topics[j].topicID, name: "" + topicLabel, 
            type: "topic", phrases: root.topics[j].labels, clickstate: "0", commentid: "0"});
    }
	
    uniqueAuthors = [];
    for (i = 0; i < nodes.length; i++) {

					// create a new javascript Date object based on the timestamp
					// multiplied by 1000 so that the argument is in milliseconds, not seconds	
					 
					if(root.domain=="slashdot"){
					var date = new Date(parseInt(nodes[i].date));
					// hours part from the timestamp
					var day=date.getDate();
					var year=date.getFullYear();
					
					var hours = date.getHours();
					// minutes part from the timestamp
					var minutes = date.getMinutes();
					// seconds part from the timestamp
					var seconds = date.getSeconds();
										
					var curr_month = date.getMonth() + 1; //Months are zero based		

					nodes[i].date = "on "+ day+"-"+curr_month+"-"+year+" at "+hours + ':' + minutes + ':' + seconds+" ";
					}					
        for (j = 0; j < topicList.length; j++) {
            for (k = 0; k < nodes[i].sent.length; k++) {
                if (topicList[j].topicID == nodes[i].sent[k].systemtopicid)
                {
                    if (topicList[j].commentid == "0") topicList[j].commentid = nodes[i].commentid;                    
                    break;
                }
            }
        }
		nodes[i].clickAuthor="0";
		nodes[i].sentences="";
		nodes[i].colorText="";
        for (j = 0; j < nodes[i].sent.length; j++) {
			nodes[i].sentences+=nodes[i].sent[j].sent+" ";			 
			var colorSentence = nodes[i].sent[j].sent;
            /* for (k = 0; k < nodes[i].sent[j].sentimentwords.length; k++) {
                //alert(nodes[i].sent[j].sentimentwords.length);
                
                if (nodes[i].sent[j].sent.contains(nodes[i].sent[j].sentimentwords[k].word)) {

                    if (nodes[i].sent[j].sentimentwords[k].polarity < 0)
						colorSentence = colorSentence.replace(nodes[i].sent[j].sentimentwords[k].word, "<strong style=\"color: rgb(125,87,189)\">" + nodes[i].sent[j].sentimentwords[k].word + "</strong>");
                    else
                        colorSentence = colorSentence.replace(nodes[i].sent[j].sentimentwords[k].word, "<strong style=\"color: rgb(230, 97, 1)\">" + nodes[i].sent[j].sentimentwords[k].word + "</strong>");
                    //alert("yes"+nodes[i].sent[j].sent);
                }
            } */
            nodes[i].colorText += colorSentence + " ";
        }

       //find Keyphrase
		nodes[i].topicText = "";
        var commentPhrase = "";
		for (j = 0; j < root.topics.length; j++) {
            for (s = 0; s < nodes[i].sent.length; s++) {
                var topicSentence = nodes[i].sent[s].sent;	
				if (root.topics[j].topicID == nodes[i].sent[s].systemtopicid)
                {
                    //alert(root.topics[j].topicID);
                    for (k = 0; k < root.topics[j].labels.length; k++) {
                        //alert(root.topics[j].labels[k].phrase);
                        var words = root.topics[j].labels[k].phrase.split(" ");
                        for (w = 0; w < words.length; w++) {
                            if (nodes[i].sent[s].sent.indexOf(words[w]) >= 0){
                                if (commentPhrase.indexOf(words[w]) < 0)
                                    commentPhrase += words[w] + " ";
								topicSentence = topicSentence.replace(words[w], "<strong style=\"color: blue\">" + words[w] + "</strong>");
							}
							//alert("contains");
                        }
                    }
					nodes[i].topicText += topicSentence + " ";
                }
            }
            nodes[i].keyPhrase = commentPhrase;
        }
	
        for (j = 0; j < uniqueAuthors.length; j++) {
            if (nodes[i].author == uniqueAuthors[j].author) {
                //alert(uniqueAuthors[j].noofcomments);
                uniqueAuthors[j].noofcomments = uniqueAuthors[j].noofcomments + 1;
                uniqueAuthors[j].commentlength = uniqueAuthors[j].commentlength + nodes[i].sent.length;
                break;
            }
        }
        if (j == uniqueAuthors.length){
            uniqueAuthors.push({author: nodes[i].author, noofcomments: 1, commentlength: nodes[i].sent.length, clickstate:"0", commentid:nodes[i].commentid});
		}
    }
	
	//sorting authors by number of comments
    uniqueAuthors.sort(function(b, a) {
        var diff = a.noofcomments - b.noofcomments;
        if (diff == 0)
            diff = a.commentlength - b.commentlength;
        return 	diff;
    });	

	var facetDiv = document.getElementById("chart");
	//facetDiv.appendChild(document.createTextNode("Topics:"));	
	var ol = document.createElement("ul");

	for (j = 0; j < topicList.length; j++) {
        var phraseAll = "";
        for (i = 1; i < topicList[j].phrases.length; i++){
            phraseAll +=topicList[j].phrases[i].phrase + "\n";
			if(i>5) break;
		}
        
		 
		var li = document.createElement("LI");
		li.setAttribute("id","li"+j);		
		li.setAttribute("class","a");
		li.innerHTML ="<div"+" id=\"div"+j+
		"\" onclick=\"clickTopic("+j+")\" style=\"border:"+"2px;\">"+ "<a href=\"#" + topicList[j].commentid + "\" title=\""+phraseAll+"\">" + 
		topicList[j].name + "</a>"
		+"</div>"; 
/*"<div class=\"topic\""+"\"onmouseover=\"topicMouseOver()\""+
					" onmouseout=\"topicMouseOut()\""+
					" onclick=\"topicMouseClick("+root.topics[j].labels[0].phrase+")\" style=\"border:"+"0px;\">"+
					"<a class=\"link-title\" href=\"#"+root.topics[j].labels[0].phrase+
					1
					"</div>";*/
		//alert(li.innerHTML);
		ol.appendChild(li);
		//$("#div" + j).css("border", "0px solid #00479D");				
	}
	//facetDiv.appendChild(ol);
	
	var facetDiv = document.getElementById("chart");	
	var ol1 = document.createElement("ul");
	//facetDiv.appendChild(document.createTextNode("Authors:"));
	var numOfAuthor=30;
	if(uniqueAuthors.length<numOfAuthor) numOfAuthor=uniqueAuthors.length;
	for (j = 0; j < numOfAuthor; j++) {
		
		var li = document.createElement("LI");
		li.setAttribute("id","li_a"+j);		
		li.setAttribute("class","b");
		li.innerHTML = "<div"+" id=\"div_a"+j+
		"\" onclick=\"clickAuthor("+j+")\" style=\"border:"+"0px;\">"+ "<a href=\"#" + uniqueAuthors[j].commentid + "\">" + 
		uniqueAuthors[j].author + "</a>"
		+"</div>"; 
		ol1.appendChild(li);
	}
	//	facetDiv.appendChild(ol1);
//	clickTopic("major army security", 1);
});


 
	function clickTopic(j) {
		link=topicList[j].name;		
		 
        if (topicList[j].clickstate == "0") {
            topicList[j].clickstate = "1";
			selectMode=1;
			$("#div" + j).css("border", "2px solid "+topicColor);
			$("#div" + j).css("background", topicClickColor);
			$("#li" + j).css("background-image", "url(blue.png)");
		}
		else{
            topicList[j].clickstate = "0";
			selectMode=0;		
			$("#div" + j).css("border", "0px solid #00479D");				
			$("#div" + j).css("background", "#fff");				
			$("#li" + j).css("background-image", "url(blue_border.png)");			
		}
		logInteraction("ClickTopic"+","+link+","+selectMode+"\n");
		commentsList = [];
		
        for (i = 0; i < nodes.length; i++) {
			var isTopic=0;
			

			
            for (j = 0; j < nodes[i].sent.length; j++) {
                if (nodes[i].sent[j].systemlabel == link) {
                    commentsList.push(nodes[i].commentid);	
					isTopic=1;
                    break;
                }
            }
			if(isTopic==1){
					
					if(selectMode=="1")
							$("#comment" +  nodes[i].commentid).html("<p>"+
							"<a href=\"#" + nodes[i].parent + "\">" + nodes[i].title + "</a>" + " " +
							nodes[i].topicText + "</p>");
					else{
						var sentences="";
						$("#comment"+nodes[i].commentid).html("<p>"+ "<a href=\"#"+nodes[i].parent+"\">"+nodes[i].title+"</a>"+" "	+nodes[i].sentences+"</p>");
					}
			}
        }
        for (j = 0; j < commentsList.length; j++) {
            if (selectMode == "1")
				//$("#div" + commentsList[j]).css("border-left", "2px solid");
                $("#div" + commentsList[j]).css("border-left", "5px solid #00479D");
            else{
                $("#div" + commentsList[j]).css("border", "0px solid");			

			}
        }
    }

	function clickAuthor(j) {	
		var name=uniqueAuthors[j].author;

        if (uniqueAuthors[j].clickstate == "0") {
            uniqueAuthors[j].clickstate = "1";
			selectMode=1;
			$("#div_a" + j).css("border", "2px solid "+authorColor);
			$("#div_a" + j).css("background", authorClickColor);
			$("#li_a" + j).css("background-image", "url(author_border.png)");
		}
		else{
            uniqueAuthors[j].clickstate = "0";
			selectMode=0;
			$("#div_a" + j).css("border", "0px solid #00479D");
			$("#div_a" + j).css("background", "#fff");
			$("#li_a" + j).css("background-image", "url(author.png)");
		}
		//alert(name);
		var selectMode="1";		
		logInteraction("ClickAuthor,"+name+","+selectMode);
		//alert("yes");
        commentsList = [];
		
        for (i = 0; i < nodes.length; i++) {
		
            if (nodes[i].author == name) {
			
				if(nodes[i].clickAuthor=="1")	nodes[i].clickAuthor="0";
				else nodes[i].clickAuthor="1";
                commentsList.push(nodes[i]);
            }
        }
		
        for (j = 0; j < commentsList.length; j++) {
		
            if (commentsList[j].clickAuthor == "1"){
				//$("#div" + commentsList[j]).css("border", "2px solid");
                $("#div" + commentsList[j].commentid).css("border-right", "5px solid #984EA3");
				
			}
            else
                $("#div" + commentsList[j].commentid).css("border-right", "0px solid");
        }

    }

 
function search(){
	alert("hello");
}	

function mouseclick(d, i) {
//	update(root);
	document.location.reload(true);
	logInteraction("Refresh");
 //alert(d3.mouse(this));
}

	
function findColor(d) {
    //return d._children ? "#3182bd" : d.children ? "#c6dbef" : "#fd8d3c";
    //return d._children ? "#c6dbef" : d.children ? "#ffffff" : "#ffffff";

//alert("hello world");

    var colorbins = new Array();
    colorbins[0] = 0;
    colorbins[1] = 0;
    colorbins[2] = 0;
    colorbins[3] = 0;
    colorbins[4] = 0;
    for (i = 0; i < d.sent.length; i++) {
        if (d.sent[i].linePolarity < -1.99) {
            colorbins[0]++;
        }
        else if (d.sent[i].linePolarity < 0) {
            colorbins[1]++;
        }
        else if (d.sent[i].linePolarity == 0) {
            colorbins[2]++;
        }
        else if (d.sent[i].linePolarity > 1.99) {
            colorbins[4]++;
        }
        else if (d.sent[i].linePolarity > 0) {
            colorbins[3]++;
        }
    }
    for (i = 0; i < colorbins.length; i++) {
        colorbins[i] = colorbins[i] / d.sent.length;
        //alert(colorbins[i]);
    }
    selectedColor = "rgb(26, 150, 65)";
    if (d.sent[0].linePolarity < 0) {
        //selectedColor="rgb("+colorFamily[1][parseInt(d.sent[0].systemtopicid)]+")";
        selectedColor = "rgb(215, 25, 28)";
    }
    return colorbins;
    //return selectedColor;  
}
function opacity(d) {
    //return d._children ? "#3182bd" : d.children ? "#c6dbef" : "#fd8d3c";
    //return d._children ? "#c6dbef" : d.children ? "#ffffff" : "#ffffff";
    opacity = 1;
    if (d.sent[0].systemtopicid < 5) {
        opacity = 0.2;
    }
    return opacity;
}
function findCommentHeight(d) {
    if (d.sent.length * 2 < minimumbarHeight)
        return minimumbarHeight;
    else if (d.sent.length * 2 > 20)
        return maximumbarHeight;
    else
        return d.sent.length * 2;
}
function showCommentTooltip(d) {
    return d.sent[0].sent + "...";
}
function logout(){
	var str= "logout";	
	logInteraction(str);
	window.location.replace("form/choose_interface.php");		
}
                        </script>
                    </div>
                </td>
                
				<td valign="top">			
				<div id="div_title"> 
				</div>
                    <div id="content" >
					
                    </div>

                </td>
            </tr>
        </table>
    </body>
</html>