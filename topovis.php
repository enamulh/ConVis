<!DOCTYPE html>
<?php
session_start();
// store session data
$_SESSION['views']=100;
?>
<html>
	
    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
        <link rel="stylesheet" type="text/css" href="style.css">	
        <script src="js/d3.js"></script>
        <script src="js/jquery1.10.js"></script>	
        <script type="text/javascript" src="js/jquery_002.js"></script>
        <script type="text/javascript" src="js/jquery_003.js"></script>
        <script type="text/javascript" src="js/init.js"></script>	
        <script type="text/javascript" src="js/jcollapsible.js"></script>		
        <script type="text/javascript" src="js/commentview.js"></script>
        <script type="text/javascript" src="js/search.js"></script>		
		<script src="js/highlight.js" type="text/javascript"></script>
        <script></script>	
    </head>
    <body>
        <table >
			<tr   align="left" >
				 <td   >
					 <div id="sentiment_legend"  align="left"> 
					 
					 </div>
				</td>
			<td>
			<table  >
			<td align="left">
				<div id="div_search"  align="right">Search
					<!--<form id="tfnewsearch" method="get" action="javascript:search()">-->
							<!--<input type="text" id="search" class="tftextinput3" size="25" maxlength="120" value="Search" onblur="highlightme()" >-->
							        <input type="text" name="search" id="search" onblur="highlightme()" />
							<span class="result-count" ></span>
					<!--</form>-->	
					<div class="tfclear"></div>
				 </div>
			</td>
			<td width=25>
				<div  id="logout" align="left" onclick="logout()" title="Finish task and logout"> 	
					<!--icons/logout.png-->
						<img src="" height=20 width=18><a href="" ></a>
				</div>	</td>
			</table>	 
				 </td>
			</tr>
			
            <tr>
                <td align="top">
                    <div id="chart">
                        <script>
	filename="";						
	interfaceName="C";
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
		  //alert("yes"+xmlhttp.responseText);
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
									/*$(function() {
				
				var self = this;
				self.input = $("#search").select().focus();
				
			    //handles searching the document
				self.performSearch = function() {
					//alert("yes");
					//create a search string
					var phrase = self.input.val().replace(/^\s+|\s+$/g, "");					
					phrase = phrase.replace(/\s+/g, "|");
					
					//make sure there are a couple letters
					//if (phrase.length < 3) { return; }			
					
					//append the rest of the expression
					phrase = ["\\b(", phrase, ")"].join("");
					
					//search for any matches
					var count = 0;
					$("#content").each(function(i, v) {
					
						//replace any matches
						var block = $(v);
						block.html(
							
							block.text().replace(
								
								new RegExp(phrase, "gi"),
								
								function(match) {
									count++;
									//alert(match);
									return ["<span class='highlight'>", match, "</span>"].join("");
								}));
					});
					
					//update the count					
					//$(".result-count").text(count + " results found!");
					
					//clear this search attempt
					//should be gone anyways...
					self.search = null;
				
				};
			
				self.search;
				self.input.keyup(function(e) {
					if (self.search) { clearTimeout(self.search); }
					
					//start a timer to perform the search. On browsers like
					//Chrome, Javascript works fine -- other less performant
					//browsers like IE6 have a hard time doing this
					self.search = setTimeout(self.performSearch, 300);
					
				});
			
			});*/
		
 
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

var w = 920,
        h = 870,
        i = 0,
        barHeight = 0,
        barWidth = w * .23,
        duration = 400,
        root,
        minimumbarHeight = 7,
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

var vis = d3.select("#chart").append("svg:svg")
        .attr("width", w)
        .attr("height", h)
        .append("svg:g")
        .attr("transform", "translate(368,0)");
		 
var rect = vis.append("rect")
    .attr("width", "100%")
	.attr("opacity", "0")	
	.attr("stroke","rgb(0,0,0)")
    .attr("height", "100%")
	.attr("transform", "translate(-368,0)")
    .on("click", mouseclick);

function search(){
	alert("hello");
	
	
}	
function mouseclick(d, i) {
//	update(root);
	document.location.reload(true);
	logInteraction("Refresh");
 //alert(d3.mouse(this));
}

d3.json(jsonFileMainView, function(json) {
    json.x0 = 0;
    json.y0 = 0;

    update(root = json);
	$( "#div_title" ).append( root.title+"\t("+nodes.length+" comments)");					
});

var topicList = [];
var topicLinks = [];
var authorList = [];
var authorLinks = [];
var threadStructureHeight = 0;
commentsList = [];

function update(source) {

    // Compute the flattened node list. TODO use d3.layout.hierarchy.
    nodes = tree.nodes(root);
    var commentHeight = new Array();
    var topicShift = 0;
    angleInDegrees = 130 / root.topics.length; //Dont want to use full 180 degree

    // compute comment height, topic shift and extractive keyphrase


    //<strong style=\"color: red\">DANGER:</strong>

    for (i = 0; i < nodes.length; i++) {
        nodes[i].colorText = "";
		nodes[i].sentences = "";
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
        for (j = 0; j < nodes[i].sent.length; j++) {
			nodes[i].sentences+=nodes[i].sent[j].sent+" ";
			var colorSentence = nodes[i].sent[j].sent;
            for (k = 0; k < nodes[i].sent[j].sentimentwords.length; k++) {
                //alert(nodes[i].sent[j].sentimentwords.length);
                
                if (nodes[i].sent[j].sent.contains(nodes[i].sent[j].sentimentwords[k].word)) {

                    if (nodes[i].sent[j].sentimentwords[k].polarity < 0)
						colorSentence = colorSentence.replace(nodes[i].sent[j].sentimentwords[k].word, "<strong style=\"color: rgb(125,87,189)\">" + nodes[i].sent[j].sentimentwords[k].word + "</strong>");
                    else
                        colorSentence = colorSentence.replace(nodes[i].sent[j].sentimentwords[k].word, "<strong style=\"color: rgb(230, 97, 1)\">" + nodes[i].sent[j].sentimentwords[k].word + "</strong>");
                    //alert("yes"+nodes[i].sent[j].sent);
                }
            }
            nodes[i].colorText += colorSentence + " ";
        }

        //alert(nodes[i].commentid);
        /*if(nodes[i].clickstate=="0")
         nodes[i].clickstate="1";
         else nodes[i].clickstate="0";*/
        nodes[i].topicShift = 1;
        commentHeight[i] = findCommentHeight(nodes[i]);
        threadStructureHeight += commentHeight[i];
        if (i > 0) {
            //if(nodes[i-1].sent[nodes[i-1].sent.length-1].systemtopicid==nodes[i].sent[0].systemtopicid)
            if (nodes[i - 1].sent[nodes[i - 1].sent.length - 1].systemtopicid == nodes[i].sent[0].systemtopicid)
                nodes[i].topicShift = 1;
            else topicShift = 0;
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

/*       nodes[i].topicText = "";
        for (j = 0; j < nodes[i].sent.length; j++) {
			
			var topicSentence = nodes[i].sent[j].sent;
            for (k = 0; k < nodes[i].sent[j].sentimentwords.length; k++) {
                //alert(nodes[i].sent[j].sentimentwords.length);
                
                if (nodes[i].sent[j].sent.contains(nodes[i].sent[j].sentimentwords[k].word)) {

                    if (nodes[i].sent[j].sentimentwords[k].polarity < 0)
						topicSentence = topicSentence.replace(nodes[i].sent[j].sentimentwords[k].word, "<strong style=\"color: red\">" + nodes[i].sent[j].sentimentwords[k].word + "</strong>");
                    else
                        topicSentence = topicSentence.replace(nodes[i].sent[j].sentimentwords[k].word, "<strong style=\"color: green\">" + nodes[i].sent[j].sentimentwords[k].word + "</strong>");
                    //alert("yes"+nodes[i].sent[j].sent);
                }
            }
            nodes[i].topicText += colorSentence + " ";
        }*/

    }

    //alert(topicLinks);
    // Compute the "layout".
    nodes.forEach(function(n, i) {
        height = 0;
        for (j = 0; j < i; j++) {
            //alert(JSON.strinify());
            height += commentHeight[j];
        }
        n.x = height;

    });

    h = height;

    arcCy = threadStructureHeight / 2;
    arcRad = threadStructureHeight / 2;
	//if(arcRad<200) arcRad=200;
	if(arcRad>390) arcRad=390;	
    //store the list of topics into an array

    var startAngle = 120;

// find min and max topic strength for font normalization purpose	
    var min = 9999, max = -9999, x;
    for (j = 0; j < root.topics.length; j++) {

        if (root.topics[j].strength < min)
            min = root.topics[j].strength;
        if (root.topics[j].strength > max)
            max = root.topics[j].strength;
    }

	

	//method 1: alphabetic order
/*	root.topics.sort(function(a, b) {			
			if(a.labels[0].phrase < b.labels[0].phrase)
				return 1;
			else if (a.labels[0].phrase > b.labels[0].phrase)
				return -1;
			return 0;
        });	
*/
	//method 2: Chronology of topic
	//WARNING: this code for sorting is highly unoptimized	
	root.topics.sort(function(a, b) {

		for(i=0;i<nodes.length;i++){			
			
			for (j = 0; j < nodes[i].sent.length; j++) {													 
				//alert(nodes[i].sent[j].systemlabel);
				if(nodes[i].sent[j].systemlabel==a.labels[0].phrase){					
					//alert(nodes[i].sent[j].systemlabel+" "+a.labels[0].phrase+" "+b.labels[0].phrase);
					return 1;
				}
				else if(nodes[i].sent[j].systemlabel==b.labels[0].phrase){					 
					return -1;
				}						
			}
			
		}
			return aComesFirst;
        });	

	for (j = 0; j < root.topics.length; j++) {
        var topicLabel = root.topics[j].labels[0].phrase;
        var angle = startAngle + angleInDegrees * j;
        var coordx = (arcRad * Math.cos((startAngle + angleInDegrees * j) * Math.PI / 180)) + arcCx;
        var coordy = (arcRad * Math.sin((startAngle + angleInDegrees * j) * Math.PI / 180)) + arcCy;

        var fontSize = (root.topics[j].strength - min) / 12 + 12;
		if(fontSize>20) fontSize=20;
        //alert(fontSize);

        topicList.push({topicID: root.topics[j].topicID, name: "" + topicLabel, x: coordx, y: coordy, angle: angle, col: topicColor, type: "topic", phrases: root.topics[j].labels, clickstate: "0", fontsize: fontSize + "px", commentid: "0"});
    }

    //linking topics with comments
    nodes.forEach(function(n, i) {
        for (j = 0; j < topicList.length; j++) {
            for (k = 0; k < n.sent.length; k++) {
                if (topicList[j].topicID == n.sent[k].systemtopicid)
                {
                    if (topicList[j].commentid == "0")
                        topicList[j].commentid = n.commentid;
                    topicLinks.push({source: {x: topicList[j].y, y: topicList[j].x, topic: n.sent[k].systemlabel}, target: {x: n.x + findCommentHeight(n) / 2, y: n.y+spaceforFacetSelector, topic: n.sent[k].systemlabel, commentid: n.commentid}, clickcomment:"0"});
                    break;
                }
            }
        }
    });

    //create list of authors and linking authors with comments
    //arcCx=200;

    var uniqueAuthors = [];
    for (i = 0; i < nodes.length; i++) {
        for (j = 0; j < uniqueAuthors.length; j++) {
            if (nodes[i].author == uniqueAuthors[j].author) {
                //alert(uniqueAuthors[j].noofcomments);
                uniqueAuthors[j].noofcomments = uniqueAuthors[j].noofcomments + 1;
                uniqueAuthors[j].commentlength = uniqueAuthors[j].commentlength + nodes[i].sent.length;
                break;
            }
        }
        if (j == uniqueAuthors.length)
            uniqueAuthors.push({author: nodes[i].author, noofcomments: 1, commentlength: nodes[i].sent.length});
    }
	
    uniqueAuthors.sort(function(b, a) {
        var diff = a.noofcomments - b.noofcomments;
        if (diff == 0)
            diff = a.commentlength - b.commentlength;
        return 	diff;
    });
	//alert(uniqueAuthors.length);
	var NumberofAuthorsTobeShown = 50; 
	if(uniqueAuthors.length<30)
		NumberofAuthorsTobeShown=uniqueAuthors.length;
	var angleInDegreesAuthors = 135 / NumberofAuthorsTobeShown; //Dont want to use full 180 degree		
    uniqueAuthors.splice(NumberofAuthorsTobeShown - 1, uniqueAuthors.length - NumberofAuthorsTobeShown);
	

    var min = 9999, max = -9999, x;
    for (j = 0; j < uniqueAuthors.length; j++) {

        if (uniqueAuthors.noofcomments < min)
            min = uniqueAuthors.noofcomments;
        if (uniqueAuthors.noofcomments > max)
            max = uniqueAuthors.noofcomments;
    }

    var countAuthor = 0;
    var authorIndex = -1;
    for (i = 0; i < nodes.length; i++) {
        for (j = 0; j < uniqueAuthors.length; j++) {
            if (nodes[i].author == uniqueAuthors[j].author) {
                authorIndex = -1;
                for (k = 0; k < authorList.length; k++) {
                    if (nodes[i].author == authorList[k].name) {
                        authorIndex = k;
                        break;
                    }
                }
                if (authorIndex == -1) {
                    var startAngle = -65;
                    var angle = startAngle + angleInDegrees * countAuthor;
                    var coordx = (arcRad * Math.cos((startAngle + angleInDegreesAuthors * countAuthor) * Math.PI / 180)) + arcCx;
                    var coordy = (arcRad * Math.sin((startAngle + angleInDegreesAuthors * countAuthor) * Math.PI / 180)) + arcCy;

                    var fontsize = (uniqueAuthors[j].noofcomments) * 3 + 8;
					if(fontsize>25) fontsize=25;
                    authorList.push({commentid: nodes[i].commentid, name: nodes[i].author, x: coordx, y: coordy, col:authorColor, type: "author", fontstroke: fontsize, clickstate: "0"});
                    authorLinks.push({source: {x: coordy, y: coordx-3, author: nodes[i].author}, target: {x: nodes[i].x + findCommentHeight(nodes[i]) / 2, y: nodes[i].y + barWidth+spaceforFacetSelector, author: nodes[i].author, commentid: nodes[i].commentid}, clickstate:"0"});
                    countAuthor++;
                }
                else {
                    var coordx1 = (arcRad * Math.cos((startAngle + angleInDegreesAuthors * authorIndex) * Math.PI / 180)) + arcCx;
                    var coordy1 = (arcRad * Math.sin((startAngle + angleInDegreesAuthors * authorIndex) * Math.PI / 180)) + arcCy;
                    //alert(authorIndex+" "+nodes[i].author+authorList[authorIndex].name);
                    for (k = 0; k < authorLinks.length; k++) {
                        if (nodes[i].author == authorLinks[k].source.author) {

                            authorLinks.push({source: {x: authorLinks[k].source.x, y: authorLinks[k].source.y, author: nodes[i].author}, target: {x: nodes[i].x + findCommentHeight(nodes[i]) / 2, y: nodes[i].y + barWidth, author: nodes[i].author, commentid: nodes[i].commentid}});
                            break;
                        }
                    }
                }
                break;
            }
        }

    }
//	alert(countif);

    // Update the nodes…
    var node = vis.selectAll("g.node")
            .data(nodes, function(d) {
        return d.id || (d.id = ++i);
    });

    nodeEnter = node.enter().append("svg:g")
            .attr("class", "node")
            .attr("transform", function(d) {
        return "translate(" + source.y0 + "," + source.x0 + ")";
    })
            .style("opacity", 1e-6);

    // Enter any new nodes at the parent's previous position.

    //draw sentiment bars

    /*nodeEnter.append("svg:rect")
     .attr("y", -barHeight / 2)
     //.attr("height", barHeight)
     .attr("height", findCommentHeight)
     .attr("width", function (d){
     return barWidth+100;
     })
     .style("fill", "rgb(255,255,255)")
     //.style("opacity", opacity)
     .on("click", click);
     */
    /*  nodeEnter.append("svg:line")
     .attr("y1",  -barHeight / 2-.1)
     //.attr("height", barHeight)
     .attr("x2", function (d){	
     //alert(d.topicShift);
     return barWidth+100;
     })
     .attr("y2",  -barHeight / 2)
     .style("stroke", function (d){
     colorLine="rgb(255,255,255)";
     if(d.topicShift==1)
     colorLine="rgb(0,0,0)";
     return colorLine;})
     .style("stroke-width","1.0px");
     */
	
	topicSelector=nodeEnter.append("svg:rect")
        .attr("commentid", function(d) {
			return d.commentid;
		})
        .attr("height", function (d){
			var h=findCommentHeight(d);
			return h-1;
		})
        .attr("width", function(d) {
			return 5;
		})
		.attr ("opacity",0)
        .style("fill", topicColor);

    nodeEnter.append("a")
            .attr("xlink:href", function(d) {
        return "#" + d.commentid;
    })
            .append("svg:rect")
			//.attr("y", function(d){alert(d.y);})
			.attr("x", function(d){return spaceforFacetSelector;})
            .attr("commentid", function(d) {
        //alert(d.commentid);
        return d.commentid;
    })
            .attr("height", findCommentHeight)
            .attr("width", function(d) {
        colorBins = findColor(d);
        return barWidth*colorBins[0];
    })
        .style("fill", "rgb(" + sentimentColors[4] + ")")
        .on("click", click)
        .on("mouseover", mouseover)
        .on("mouseout", mouseout)
        .append("title").text(showCommentTooltip);

			
	nodeEnter.append("svg:a")
            .attr("xlink:href", function(d) {
        return "#" + d.commentid;
    })
            .append("svg:rect")
            .attr("y", -barHeight / 2)
			.attr("x", function(d){
				colorBins = findColor(d);				
				return spaceforFacetSelector + barWidth * colorBins[0];
			})			
            .attr("height", findCommentHeight)
            .attr("commentid", function(d) {
        return d.commentid;
    })
            .attr("width", function(d) {
        colorBins = findColor(d);
        return  (barWidth * colorBins[1]);
    })
            .style("fill", "rgb(" + sentimentColors[3] + ")")
            //.append("title").text(showCommentTooltip) 
            .on("mouseover", mouseover)
            .on("mouseout", mouseout)
            .on("click", click).append("title").text(showCommentTooltip);

    nodeEnter.append("svg:a")
        .attr("xlink:href", function(d) {
        return "#" + d.commentid;
    })
            .append("svg:rect")
            .attr("y", -barHeight / 2)
			.attr("x", function(d){
				colorBins = findColor(d);				
				return spaceforFacetSelector + barWidth * colorBins[0]+barWidth * colorBins[1];
				
			})			
            .attr("height", findCommentHeight)
            .attr("commentid", function(d) {
        return d.commentid;
    })
        .attr("width", function(d) {
        colorBins = findColor(d);
		return  (barWidth * colorBins[2]);        
    })

            .style("fill", "rgb(" + sentimentColors[2] + ")")
            .on("click", click)
            .on("mouseover", mouseover)
            .on("mouseout", mouseout)
            .append("title").text(showCommentTooltip);

    nodeEnter.append("svg:a")
            .attr("xlink:href", function(d) {
        return "#" + d.commentid;
    })
            .append("svg:rect")
            .attr("y", -barHeight / 2)
			.attr("x", function(d){
				colorBins = findColor(d);				
				return spaceforFacetSelector + barWidth * colorBins[0]+barWidth * colorBins[1]+barWidth * colorBins[2];
				
			})			

            .attr("height", findCommentHeight)
            .attr("commentid", function(d) {
        return d.commentid;
    })
            .attr("width", function(d) {
        colorBins = findColor(d);
        return  barWidth * colorBins[3];
    })
            .style("fill", "rgb(" + sentimentColors[1] + ")")
            .on("click", click)
            .on("mouseover", mouseover)
            .on("mouseout", mouseout)
            .append("title").text(showCommentTooltip);

    nodeEnter.append("svg:a")
            .attr("xlink:href", function(d) {
        return "#" + d.commentid;
    })
        .append("svg:rect")
        .attr("y", function (d){
				//alert(-barHeight / 2);
			return -barHeight / 2;})
		.attr("x", function(d){
				colorBins = findColor(d);				
				return spaceforFacetSelector + barWidth * colorBins[0]+barWidth * colorBins[1]+barWidth * colorBins[2]+barWidth * colorBins[3];
		})
        .attr("height", findCommentHeight)
        .attr("commentid", function(d) {
        return d.commentid;
    })
        .attr("width", function(d) {
        colorBins = findColor(d);
        return  barWidth * colorBins[4];
    })
        .style("fill", "rgb(" + sentimentColors[0] + ")")
        .on("click", click)
        .on("mouseover", mouseover)
        .on("mouseout", mouseover)
        .append("title").text(showCommentTooltip);

	authorSelector=nodeEnter.append("svg:rect")
        .attr("commentid", function(d) {
			return d.commentid;
		})
		.attr("x", function(d){
			colorBins = findColor(d);				
			return spaceforFacetSelector +2+barWidth;
			})		
        .attr("height", function (d){
			var h=findCommentHeight(d);
			return h-1;
		})
        .attr("width", function(d) {
			return 5;
		})
		.attr ("opacity",0)
        .style("fill", authorColor);
		
    /*nodeEnter.append("svg:text")
     .attr("dy", 1.0)
     .attr("dx", 170)
     .style("fill", "black")
     .text(function(d) {
     return d.keyPhrase;
     })*/

    // Transition nodes to their new position.
    nodeEnter.transition()
            .duration(duration)
            .attr("transform", function(d) {
        return "translate(" + d.y + "," + d.x + ")";
    })
            .style("opacity", 1);
    /*  
     node.transition()
     .duration(duration)
     .attr("transform", function(d) { return "translate(" + d.y + "," + d.x + ")"; })
     .style("opacity", 1)
     .select("rect")
     .style("fill", "rgb(26, 150, 65)");
     */

    // Transition exiting nodes to the parent's new position.
    node.exit().transition()
            .duration(duration)
            .attr("transform", function(d) {
        return "translate(" + source.y + "," + source.x + ")";
    })
            .style("opacity", 1e-6)
            .remove();

    // Update the links…
    /*  var link = vis.selectAll("path.link")
     .data(tree.links(nodes), function(d) { return d.target.id; });

     // Enter any new links at the parent's previous position.
     link.enter().insert("svg:path", "g")
     .attr("class", "link")
     .attr("d", function(d) {
     var o = {x: source.x0, y: source.y0};
     return diagonal({source: o, target: o});
     })
     .transition()
     .duration(duration)
     .attr("d", diagonal);

     // Transition links to their new position.
     link.transition()
     .duration(duration)
     .attr("d", diagonal);

     // Transition exiting nodes to the parent's new position.
     link.exit().transition()
     .duration(duration)
     .attr("d", function(d) {
     var o = {x: source.x, y: source.y};
     return diagonal({source: o, target: o});
     })
     .remove();
     */

    var linkTopicComments = vis.selectAll(".linktopics")
            .data(topicLinks)
            .enter().append("path")
            .attr("class", "linktopics")
            .attr("d", topicDiagonal)
            .attr("opacity", "0.3");

    var linkAuthorComments = vis.selectAll(".linkauthors")
            .data(authorLinks)
            .enter().append("path")
            .attr("class", "linkauthors")
            .attr("d", topicDiagonal)
            .attr("opacity", "0.3");
    //var combine=topicList.concat(authorList);
    var circle = vis.selectAll(".circle")
            .data(topicList)
            .enter()
            .append("g")
            .attr("class", "circle")
            .attr("fill", function(d) {
        return d.col;
    })
            .attr("opacity", ".5");

    var circleTopics = circle.append("circle")
            .attr("cx", function(d) {
        return d.x;
    })
            .attr("cy", function(d) {
        return d.y;
    })
            .attr("r", radius)
            .append("title").text(function(d) {
        var phrases = "";
        for (i = 0; i < d.phrases.length; i++){
            phrases += d.phrases[i].phrase + "\n";
			if(i>4) break;
		}
        return phrases;
    });

    textTopics = vis.selectAll("textTopics").data(topicList);

    drawTopicText();

    textTopics.each(function() {
        var bbox = this.getBBox();
        textHeight = bbox.height;
    });

    /*var bbox = textElement.getBBox();
     var width = bbox.width;
     var height = bbox.height;		*/

    roundedRect = vis.selectAll(".roundedrect")
            .data(topicList)
            .enter()
            .append("svg:rect")
            .attr("rx", 6)
            .attr("ry", 6)			
            .attr("x", function(d) {
        rectName = d.name;
        var width;
        textTopics.each(function(d) {
            if (d.name == rectName) {
                var bbox = this.getBBox();
                width = bbox.width;
            }
        });
        return d.x - width - 10;
    })
            .attr("y", function(d) {
        return d.y - textHeight + textHeight / 4;
    })
            .attr("width", function(d) {
        rectName = d.name;
        var width;
        textTopics.each(function(d) {

            if (d.name == rectName) {
                var bbox = this.getBBox();
                width = bbox.width;
            }

        });
        return width + 4;
    })
            .attr("height", textHeight + 2)
            //.attr("transform", function(d, i) { return "scale(" + (1 - d / 25) * 20 + ")"; })            
            .style("opacity", "0")
            .style("stroke-width", "2px");
	
	
	textTopics.remove();
	drawTopicText();
	
	
    /*	vis.append("svg:rect")
     .attr("rx", 6)
     .attr("ry", 6)
     .attr("x", -12.5)
     .attr("y", -12.5)
     .attr("width", 25)
     .attr("height", 25)
     //.attr("transform", function(d, i) { return "scale(" + (1 - d / 25) * 20 + ")"; })
     .style("fill", d3.scale.category20c());			*/

    var imgsAuthors = vis.selectAll("image").data(authorList);
    imgsAuthors.enter()
            .append("svg:image")
            .attr("x", function(d) {
        return d.x - 10;
    })
            .attr("y", function(d) {
        return d.y - 8;
    })
            .attr("xlink:href", "icons/author.png")
            .attr("width", "14")
            .attr("height", "15")
            .attr("opacity", ".5");

    textAuthor = vis.selectAll("textAuthors").data(authorList);
	drawAuthorText();
    authorRect = vis.selectAll(".authorrect")
            .data(authorList)
            .enter()
            .append("a")
            .attr("xlink:href", function(d) {
        return "#" + d.commentid;
    })
            .append("svg:rect")
            .attr("rx", 6)
            .attr("ry", 6)
            .attr("x", function(d) {
        rectName = d.name;
        var width;
        textAuthor.each(function(d) {

            if (d.name == rectName) {
                var bbox = this.getBBox();
                width = bbox.width;
            }
        });
        return d.x + 5;
    })
            .attr("y", function(d) {
        return d.y - textHeight + textHeight / 3+6;
    })
            .attr("width", function(d) {
        rectName = d.name;
        var width;
        textAuthor.each(function(d) {

            if (d.name == rectName) {
                var bbox = this.getBBox();
                width = bbox.width;
            }

        });
        return width + 8;
    })
            .attr("height", textHeight-4)
            //.attr("transform", function(d, i) { return "scale(" + (1 - d / 25) * 20 + ")"; })
            .style("fill", "white")
            .style("stroke-width", "2px");

	textAuthor.remove();
	drawAuthorText();			
		
    vis.selectAll("image")
            .on("mouseover", function(d) {
        aut = d.name;
        d3.select(this)
                .transition()
                .duration(duration)
                .attr("opacity", "1");
        highlightCommentsbyAuthor(aut);
        highlightAuthorsLinks();
        highlightTopicLinks();
        highlightAuthorsbyAuthor(aut);
        highlightTopicsbyAuthor(aut);
    });

    vis.selectAll("image")
            .on("mouseout", function(d) {
		undoHighlightAuthorsLinks();
        d3.select(this)
                .transition()
                .duration(duration)
                .attr("opacity", ".5");
        undoHighlightCommentsbyAuthor(aut);
        commentsList = [];
    });

    /*  var testCircle = circle.append("circle")
     .attr("cx", arcCx)
     .attr("cy", arcCy)
     .attr("r", radius)
     .style("fill", "red");*/

    vis.selectAll(".circle")
            .on("mouseout", function(d) {
        topicName = d.name;
        undoHighlightTopicsbyTopic(topicName);
        undoHighlightCommentsbyTopic(topicName);
        commentsList = [];
    });

    textTopics.on("mouseover", function(d) {
        topicName = d.name;
        highlightTopicsbyTopic(topicName);
        highlightCommentsbyTopic(topicName);
        highlightAuthorsbytopic(topicName);
        highlightTopicLinks();
        highlightAuthorsLinks();
    });

    roundedRect.on("mouseover", function(d) {
        topicName = d.name;
        highlightTopicsbyTopic(topicName);
        highlightCommentsbyTopic(topicName);
        highlightAuthorsbytopic(topicName);
        highlightTopicLinks();
        highlightAuthorsLinks();
    });

    textTopics.on("mouseout", function(d) {
        topicName = d.name;
        undoHighlightTopicsbyTopic(topicName);
        undoHighlightCommentsbyTopic(topicName);
        commentsList = [];
    });

    roundedRect.on("mouseout", function(d) {
        topicName = d.name;
        undoHighlightTopicsbyTopic(topicName);
        undoHighlightCommentsbyTopic(topicName);
        commentsList = [];
    });
    textTopics.on("click", function(d) {
        if (d.clickstate == "1") {
            d.clickstate = "0";
            TopicName = d.name;
            undoHighlightTopicsbyTopic(topicName);
            undoHighlightCommentsbyTopic(topicName);
            commentsList = [];
        }
        else
            d.clickstate = "1";
        topicName = d.name;
        highlightTopicsbyTopic(topicName);
        highlightCommentsbyTopic(topicName);
        highlightAuthorsbytopic(topicName);
        highlightTopicLinks();
        highlightAuthorsLinks();
        clickTopic(topicName, d.clickstate);
    });

    roundedRect.on("click", function(d) {
        if (d.clickstate == "1") {
            d.clickstate = "0";
            TopicName = d.name;
            undoHighlightTopicsbyTopic(topicName);
            undoHighlightCommentsbyTopic(topicName);
            commentsList = [];
        }
        else
            d.clickstate = "1";
        topicName = d.name;
        highlightTopicsbyTopic(topicName);
        highlightCommentsbyTopic(topicName);
        highlightAuthorsbytopic(topicName);
        highlightTopicLinks();
        highlightAuthorsLinks();
        clickTopic(topicName, d.clickstate);
    });

    textAuthor.on("mouseover", function(d) {
        aut = d.name;
        highlightCommentsbyAuthor(aut);
        highlightAuthorsLinks();
        highlightTopicLinks();
        highlightAuthorsbyAuthor(aut);
        highlightTopicsbyAuthor(aut);
    });

    authorRect.on("mouseover", function(d) {
        aut = d.name;

        highlightCommentsbyAuthor(aut);
        highlightAuthorsLinks();
        highlightTopicLinks();
        highlightAuthorsbyAuthor(aut);
        highlightTopicsbyAuthor(aut);
    });
    textAuthor.on("mouseout", function(d) {
        aut = d.author;

        undoHighlightCommentsbyAuthor(aut);
    });
    authorRect.on("mouseout", function(d) {
        aut = d.author;

        aut = d.name;
        commentsList = [];
        undoHighlightCommentsbyAuthor(aut);
    });

    authorRect.on("click", function(d) {
        if (d.clickstate == "1") {
            d.clickstate = "0";
            authorName = d.name;
            undoHighlightCommentsbyAuthor(aut);
            commentsList = [];
        }
        else
            d.clickstate = "1";
        author = d.name;
        clickAuthor(author, d.clickstate);
    });
	
    textAuthor.on("click", function(d) {
        if (d.clickstate == "1") {
            d.clickstate = "0";
            authorName = d.name;
            undoHighlightCommentsbyAuthor(aut);
            commentsList = [];
        }
        else
            d.clickstate = "1";
        author = d.name;
        clickAuthor(author, d.clickstate);
    });
    // Stash the old positions for transition.
    nodes.forEach(function(d) {
        d.x0 = d.x;
        d.y0 = d.y;
    });

//draw topic text
function drawTopicText(){
    textTopics.enter()
            .append("a")
            .attr("xlink:href", function(d) {
        return "#" + d.commentid;
    })
            .attr("transform", function(d) {
        return "translate(" + (-(d.name.length * 8.5)) + ")";
    })
            .append("svg:text")
            /*.attr("transform", function(d) {
             return "translate(" + (-(d.name.length*8.5))+ ")"; 
             })*/
            .style("font-size", function(d) {
        return d.fontsize;
    })
            .attr("x", function(d) {
        return d.x;
    })
            .attr("y", function(d) {
        return d.y + radius / 2;
    })
            .attr("fill", function(d) {
        return d.col;
    })

            .text(function(d) {
        return d.name;
    })
            .append("title").text(function(d) {
			var phrases = "";
			for (i = 1; i < d.phrases.length; i++){
				phrases += d.phrases[i].phrase + "\n";
				if(i>4) break;
			}
			return phrases;
    })

    textTopics.transition()
            .attr("transform", function(d, i) {
        var bbox = this.getBBox();
        return "translate(" + (-(bbox.width + radius + 2)) + ")";
    });	
	
}
function drawAuthorText(){
    textAuthor.enter()
            .append("a")
            .attr("xlink:href", function(d) {
        return "#" + d.commentid;
    })
            .append("svg:text")
            .attr("transform", function(d) {
        return "translate(" + 10 + ")";
    })
            .style("font-size", function(d) {
        return d.fontstroke + "px";
    })
            .attr("x", function(d) {
        return d.x;
    })
            .attr("y", function(d) {
        return d.y;
    })
            //.attr("dx", "6") // margin
            .attr("dy", ".30em") // vertical-align
            .attr("fill", function(d) {
        return d.col;
    }) // vertical-align		
            .text(function(d) {
        return d.name;
    });
} 	
	// if the user click a particular topic	
	function clickTopic(link, selectMode) {
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
							"<a href=\"#" + nodes[i].parent + "\">" + nodes[i].title + ":</a>" + " " +
							nodes[i].topicText + "</p>");
					else{ 
						var sentences="";
						$("#comment"+nodes[i].commentid).html("<p>"+ "<a href=\"#"+nodes[i].parent+"\">"+nodes[i].title+":</a>"+" "	+nodes[i].sentences+"</p>");
					}
			}
        }
		// draw border around comments in thread view
        /*nodeEnter.transition()
                .duration(0)
                .selectAll("rect")
				//.style("stroke","rgb(0, 71, 157)")	
                .style("stroke-width", function(d, i) {
            var stroke = "0.25px";
			if(d.clickstate=="1") stroke="2px";			
            for (i = 0; i < d.sent.length; i++) {
                if (d.sent[i].systemlabel == link) {
					if(selectMode=="1"){
						d.clickstate="1";
						stroke = "2px";                    
						}
					else{
						d.clickstate="0";						
						stroke="0.25px";
					}
                    break;
                }
            }
            return stroke;
        });*/
		
		
		topicSelector.transition()
                .duration(duration)
                .style("opacity", function(d, i) {
            var op = "0";

			if(d.clickstate=="1") op="1";
            for (i = 0; i < d.sent.length; i++) {
                if (d.sent[i].systemlabel == link) {
					if(selectMode=="1"){
						d.clickstate="1";
						op = "1";                    
						}
					else{
						d.clickstate="0";						
						op="0";
					}
                    break;
                }
            }			
			
            return op;
        });
		// fade border when toggle click
        roundedRect.transition()
                .duration(0)
				.style("fill",topicClickColor)	
                .style("opacity", function(d, i) {
            var op = "0";
			if (d.clickstate == "1") {
					op= "1";
				}
            if (link == d.name) {
				if(selectMode=="1") op = "1";
				
            }
            return op;
        })
		
        for (j = 0; j < commentsList.length; j++) {
            if (selectMode == "1")
				//$("#div" + commentsList[j]).css("border-left", "2px solid");
                $("#div" + commentsList[j]).css("border-left", "5px solid #00479D");
            else{
                $("#div" + commentsList[j]).css("border", "0px solid");			

			}
        }
		//highlightTopicLinks();
    }
	
    function clickAuthor(name, selectMode) {
		logInteraction("ClickAuthor,"+author);
        commentsList = [];
        for (i = 0; i < nodes.length; i++) {
            if (nodes[i].author == name) {
				if(selectMode=="1")	nodes[i].clickAuthor="1";
				else nodes[i].clickAuthor="0";
                commentsList.push(nodes[i].commentid);
            }
        }
		
        for (j = 0; j < commentsList.length; j++) {
            if (selectMode == "1")
				//$("#div" + commentsList[j]).css("border", "2px solid");
                $("#div" + commentsList[j]).css("border-right", "5px solid #984EA3");
            else
                $("#div" + commentsList[j]).css("border-right", "0px solid");
        }
		
		// draw border around comments in thread view		
        /*nodeEnter.transition()
            .duration(duration)
            .selectAll("rect")
			/*.style("stroke",function(d, i) {
				//alert(d.author);
				//alert(this.property("stroke"));
                if (d.author == name) {					
					if(selectMode=="1"){
						return "rgb(152, 78, 163)";                    
					}
				}
        })*/
        /*.style("stroke-width", function(d, i) {
				var stroke = "0.25px";
					if(d.clickstate=="1") stroke="2px";

                if (d.author == name) {
					
					if(selectMode=="1"){
						//alert(d.author);
						d.clickstate="1";
						stroke = "2px";
						}
					else{
						d.clickstate="0";
						stroke="0.25px";
					}
            }

            return stroke;
        });*/
		
		topicSelector.transition()
                .duration(duration)
                .style("opacity", function(d, i) {
					var op = "0";
					if(d.clickstate=="1"){
						op="0.2";
						if (d.author == author) op="1";
					}		
					return op;
        });
		updateAuthorSelector("1");
		// fade border when toggle click
        authorRect.transition()
                .duration(0)
				.style("fill",function(d,i){
					if(d.clickstate=="1") return authorClickColor;					
				})	
                .style("opacity", function(d, i) {
            var op = "0";
            if (name == d.name) {
				if(selectMode=="1") op = "1";
            }
            return op;
        })	
    }
	
// Toggle children on click.
    function click(d) {
		logInteraction("ClickComment,"+d.commentid);
        for (i = 0; i < nodes.length; i++) {
            if (nodes[i].commentid == d.commentid) {
                if (nodes[i].clickcomment == "1")
                    nodes[i].clickcomment = "0";
                else
                    nodes[i].clickcomment = "1";
                break;
            }
        }

    nodeEnter.transition()
                .duration(0)
                .selectAll("rect")
                .style("stroke-width", function(s, i) {
            var stroke = "0.25px";
            if (s.clickcomment == "1") {
                //stroke = "2px";
                $("#div" + s.commentid).css("border-top", "2px solid");
				$("#div" + s.commentid).css("border-bottom", "2px solid");
            }
            else{
                $("#div" + s.commentid).css("border-top", "0px solid");
				$("#div" + s.commentid).css("border-bottom", "0px solid");
			}	
            if (d.commentid == s.commentid) {
                /*if(d.clickstate=="1") 
                 {d.clickstate="0";}*/
                //if (d.clickstate == "1")
                //{
                    $("#comment" + d.commentid).html("<p>" +
                            "<a href=\"#" + d.parent + "\">" + d.title + ":</a>" + " " +
                            d.colorText +
                            "</p>");
                    //d.clickstate="1";
                //}
                /*else{
				
                 $("#comment"+d.commentid).html("<p>"+
                 "<a href=\"#"+d.parent+"\">"+d.title+":</a>"+" "	+d.sentences+"</p>");

                 }*/
            }
            return stroke;
        });

        /*if (d.children) {
         d._children = d.children; //collapsed-> d._children
         d.children = null;
         } else {
         d.children = d._children;
         d._children = null;
         }
         update(d);*/
    }

// mouse over comment
    function mouseover(d) {

/*var testCircle = circle.append("circle")
     .attr("cx", d.y)
     .attr("cy", d.x)
     .attr("r", 2)
     .style("fill", "red");
*/
	logInteraction("ThreadMouseOver", d.commentid);
	delete mouseOverLine1;
	delete mouseOverLine2;
	
	drawLineMouseOver(d);
	$("#div"+d.commentid).css("border-top", "2px solid");	
	$("#div"+d.commentid).css("border-bottom", "2px solid");	

	//alert(d.x);
	//alert(d.y);
	
        commentsList = [];
        commentsList[0] = d.commentid;
        highlightAuthorsbytopic("dummy");
        highlightAuthorsLinks();

        highlightTopicsbyAuthor(d.author);
        highlightTopicLinks();
    }

// mouse out from comment
    function mouseout(d) {
		logInteraction("ThreadMouseOut", d.commentid);	
        undoHighlightCommentsbyAuthor(d.author);

		//mouseOverLine1.remove();
		//mouseOverLine2.remove();		
		
		vis.selectAll("line").remove();
        nodeEnter.transition()
            .duration(0)
            .selectAll("rect")
            .style("stroke-width", function(s, i) {
				var stroke = "0.25px";
				//if (s.clickstate == "1")
				//	stroke = "2px";
				//if($("#div"+d.commentid).attr('style').indexOf("rgb")==-1)		
				$("#div"+d.commentid).css("border-top", "0px solid");
				$("#div"+d.commentid).css("border-bottom", "0px solid");
					 
				return stroke;
        });		
    }


}

	function drawLineMouseOver(d){
	mouseOverLine1 = vis.append("svg:line")
		.attr("x1", d.y+spaceforFacetSelector)
		.attr("y1", d.x)
		.attr("y2", d.x)
		.attr("x2", d.y+spaceforFacetSelector+barWidth)
		.style("stroke", "rgb(0,0,0)")
		.style("stroke-width", "1.5px"); 

	mouseOverLine2 = vis.append("svg:line")
		.attr("x1", d.y+spaceforFacetSelector)
		.attr("y1", d.x+findCommentHeight(d))
		.attr("y2", d.x+findCommentHeight(d))
		.attr("x2", d.y+spaceforFacetSelector+barWidth)
		.style("stroke", "rgb(0,0,0)")
		.style("stroke-width", "1.5px"); 
	
	}	

    function highlightTopicsbyTopic(link) {
		logInteraction("HoverTopic,"+link);
        vis.selectAll(".circle")
                .transition()
                .duration(duration)
                .attr("opacity", function(d, i) {
            if (topicName == d.name)
                return "1";
            else if (d.clickstate == "1") {
                return "1";
            }
            else
                return "0.3";
        });

        roundedRect.transition()
                .duration(duration)
				//.style("fill","none")	
				.style("fill",function(d){
					var fill="none";
					if (d.clickstate == "1")
						fill=topicClickColor;
					return fill;
				})	
                .style("opacity", function(d, i) {
				
            var op = "0";
            if (link == d.name) {				
                op = "1";
            }
            else if (d.clickstate == "1")
                op = "1";
            //alert("helo");
            return op;
        })
        .style("stroke", function(d, i) {
            var stroke = "none";
			if (link == d.name) {
				stroke = d.col;
            }
            else if (d.clickstate == "1")
                stroke = d.col;
            return stroke;
        }
        );
		/*textTopics.transition()
			.attr("style", function(d,i){
				fontstyle= "font-weight:regular;";	
				if(d.clickstate=="1") fontstyle="font-weight:bold;";
				if(link==d.name){
					fontstyle= "font-weight:bold;";
				}
				return fontstyle;
			});		
*/
		//roundedRect.transition().duration(0).style("fill","none")	;
    }

    function highlightCommentsbyTopic(link) {
        nodeEnter.transition()
                .duration(duration)
                .selectAll("rect")
                .style("opacity", function(d, i) {			
            var opac = "0.2";			
            for (i = 0; i < d.sent.length; i++) {
                if (d.sent[i].systemlabel == link) {
                    opac = "1";
                    commentsList.push(d.commentid);
                    break;
                }				
            }
            return opac;
        });
		
		topicSelector.transition()
                .duration(duration)
                .style("opacity", function(d, i) {
					var op = "0";
					if(d.clickstate=="1"){
							op="0.2";
						for (i = 0; i < d.sent.length; i++) {
							if (d.sent[i].systemlabel == link) {
								op = "1";						
								break;
							}
						}
					}
					return op;
        });
		
		updateAuthorSelector("0.2");
		
    }

    function highlightCommentsbyAuthor(author) {
        nodeEnter.transition()
                .duration(duration)
                .selectAll("rect")
                .style("opacity", function(d, i) {
            var opac = "0.2";
            for (i = 0; i < d.sent.length; i++) {
                if (d.author == author) {
                    opac = "1";
                    commentsList.push(d.commentid);
                    break;
                }
            }
            return opac;
        });
		topicSelector.transition()
                .duration(duration)
                .style("opacity", function(d, i) {
					var op = "0";
					if(d.clickstate=="1"){
							op="0.2";
						if (d.author == author) op="1";
					}		
					return op;
        });
		updateAuthorSelector("1");
		
    }
   function highlightAuthorsbytopic(link) {
		 
        var authorstobeHighlighted = [];
        for (i = 0; i < nodes.length; i++) {
            for (j = 0; j < commentsList.length; j++) {
				
                if (nodes[i].commentid == commentsList[j]) {
					 
                    authorstobeHighlighted.push(nodes[i].author);
                    break;
                }
            }
        }
        vis.selectAll("image").transition()
                .duration(0)
                .attr("opacity", function(d, i) {
            var opacAuthor = "0.3";
            for (i = 0; i < authorstobeHighlighted.length; i++) {
                if (authorstobeHighlighted[i] == d.name) {
                    opacAuthor = "1";
                    break;
                }
            }
            return opacAuthor;
        });
 
        authorRect.transition()
                .duration(0)
                .style("opacity", function(d, i) {
            var op = "0";
            for (i = 0; i < authorstobeHighlighted.length; i++) {
                if (authorstobeHighlighted[i] == d.name) {
                    op = "0.3";
                    break;
                }
            }
            if (d.clickstate == "1")
                op = "1";
            return op;
        });
        authorRect.style("fill", function(d, i) {
            var stroke = "rgb(255, 255,255)";
            for (i = 0; i < authorstobeHighlighted.length; i++) {
                if (authorstobeHighlighted[i] == d.name) {
                    stroke = d.col;
                    break;
                }
            }
            if (d.clickstate == "1")
                stroke = authorClickColor;
            return stroke;
        }
        );
        //.style("fill",function(d,i){	return d.col;})	;  
    }
   function highlightAuthorsbyAuthor(author) {
		logInteraction("HoverAuthor,"+author);
        vis.selectAll("image")
                .transition()
                .duration(duration)
                .attr("opacity", function(d, i) {
            var op = "0.3";
            if (author == d.name)
                op = "1";
            else if (d.clickstate == "1")
                op = "1";
            return op;
        });
 

        authorRect.transition()
                .duration(duration)
				.style("fill","none")
                .style("opacity", function(d, i) {
            var op = "0";
            for (i = 0; i < commentsList.length; i++) {
                if (commentsList[i] == d.commentid) {
                    op = "1";
                    break;
                }
            }
            if (d.clickstate == "1") {
                op = "1";
            }
            return op;
        })
		.style("stroke", function(d, i) {

            var stroke = "rgb(255, 255,255)";
            for (i = 0; i < commentsList.length; i++) {
                if (commentsList[i] == d.commentid) {
                    stroke = d.col;
                    break;
                }
            }
            if (d.clickstate == "1")
                stroke = d.col;
            return stroke;
        }
        )

    }
    function highlightTopicsbyAuthor(link) {

        roundedRect.transition()
                .duration(duration)
                .style("opacity", function(d, i) {
            var op = "0";
            labelsbyCommentID();
//					alert(systemLabels.length);
            for (i = 0; i < systemLabels.length; i++) {
                if (systemLabels[i] == d.name) {
                    op = "0.3";
                    break;
                }
            }
            if (d.clickstate == "1")
                op = "1";
            return op;
        })
        .style("fill", function(d, i) {
            var stroke = "none";
 
            labelsbyCommentID();
            for (i = 0; i < systemLabels.length; i++) {

                if (systemLabels[i] == d.name) {
                    stroke = d.col;
                    break;
                }
            }
            if (d.clickstate == "1")
                stroke = topicClickColor;
            return stroke;
        });

        vis.selectAll(".circle")
                .transition()
                .duration(duration)
                .attr("opacity", function(d, i) {
            var op = "0.3";
            for (i = 0; i < systemLabels.length; i++) {

                if (systemLabels[i] == d.name) {
                    op = "1";
                    break;
                }
            }
            if (d.clickstate == "1")
                op = "1";
            return op;
        });


    }
    function labelsbyCommentID() {
        systemLabels = [];
        for (i = 0; i < commentsList.length; i++) {
            for (j = 0; j < nodes.length; j++) {
                if (nodes[j].commentid == commentsList[i])
                {
                    for (s = 0; s < nodes[s].sent.length; s++) {
                        systemLabels.push(nodes[j].sent[s].systemlabel);
                    }
                    break;
                }
            }
        }
    }
    function highlightTopicLinks() {
        vis.selectAll(".linktopics")
                .transition()
                .attr("opacity", function(d, i) {
            var opac = ".2";
            for (i = 0; i < commentsList.length; i++) {
				if (d.clickstate=="1")
					opac="1";
                else if (d.target.commentid == commentsList[i]){
					//d.clickstate="1";
                    opac = "1";
				}	
            }
            return opac;
        });
    }

    function highlightAuthorsLinks() {
        vis.selectAll(".linkauthors")
                .transition()
                .attr("opacity", function(d, i) {
            var opac = ".3";

            for (i = 0; i < commentsList.length; i++) {
                if (d.target.commentid == commentsList[i])
                    opac = "1";
            }
            return opac;
        });
    }

    function undoHighlightTopicsbyTopic(link) {

		undohighlightTopicLinks();
		undoHighlightAuthorsLinks();

		
		
		
        vis.selectAll(".circle")
                .transition()
                .duration(duration)
                .attr("opacity", function(d, i) {

            var opac = "0.3";
            if (d.clickstate == "1") {
                opac = "1";
            }
            return opac;
        });
 

        roundedRect.transition()
                .duration(duration)
                .style("opacity", function(d, i) {

            var opac = "0.0";
            if (d.clickstate == "1") {
                opac = "1";
            }
            return opac;
        });

    }

    function undoHighlightCommentsbyTopic(link) {
        nodeEnter.transition()
                .duration(duration)
                .selectAll("rect")
                .style("opacity", function(d, i) {
            var opac = "1";
            for (i = 0; i < d.sent.length; i++) {
                if (d.sent[i].systemlabel == link) {
                    aut = d.author;
                    opac = "1";
                    break;
                }
            }
            return opac;
        });

		topicSelector.transition()
                .duration(duration)
                .style("opacity", function(d, i) {
            var op = "0";

			if(d.clickstate=="1") op="1";			
            return op;
        });		
		updateAuthorSelector("1");
		/*topicSelector.transition()
                .duration(duration)
                .style("opacity", function(d, i) {
					var op = "0";
					if(d.clickstate=="1")
							op="1";
					return op;
        })*/
		
        vis.selectAll("image").transition()
                .duration(duration)
                .attr("opacity", function(d, i) {
            if (d.clickstate == "1")
                return "1";
            else
                return "0.3";
        });

        authorRect.transition()
                .duration(0)
                .style("opacity", function(d, i) {
            var opac = "0.0";
            opac = "0.0";
            if (d.clickstate == "1")
                opac = "1";
            return opac;
        })
        .style("fill", function(d, i) {
			if(d.clickstate=="1")	return authorClickColor;
			}
			);
    }


    function undoHighlightCommentsbyAuthor(author) {
        nodeEnter.transition()
                .duration(duration)
                .selectAll("rect")
                .style("opacity", function(d, i) {
            var opac = "1";
            return opac;
        });
		topicSelector.transition()
                .duration(duration)
                .style("opacity", function(d, i) {
					var op = "0";
					if(d.clickstate=="1")	op="1";							
					return op;
		});
		updateAuthorSelector("1");
        /*topicSelector.transition()
            .duration(duration)
            .selectAll("rect")
            .style("opacity", function(d, i) {
				var opac = "0";
				if(d.clickstate=="1")
					opac = "1";
				return opac;
        });		*/
		
		undohighlightTopicLinks();
        undoHighlightAuthor();
        roundedRect.transition()
                .duration(duration)
                .style("opacity", function(d, i) {
            //alert(d.name);
            var op = "0";
            labelsbyCommentID();
            for (i = 0; i < systemLabels.length; i++) {

                if (systemLabels[i] == d.name) {
                    op = "0";
                    break;
                }
            }
            if (d.clickstate == "1")
                op = "1";
            return op;
        })
                .style("fill", function(d, i) {

            var stroke = "none";
			if(d.clickstate=="1") return topicClickColor;			
        });

        vis.selectAll(".circle")
                .transition()
                .duration(duration)
                .attr("opacity", function(d, i) {
            var op = "0.3";
            for (i = 0; i < systemLabels.length; i++) {

                if (systemLabels[i] == d.name) {
                    op = "0.3";
                    break;
                }
            }
            return op;
        });

    }

    function undoHighlightAuthor() {
        vis.selectAll("image").transition()
                .duration(duration)
                .attr("opacity", function(d, i) {
            opac = "0.3";
            if (d.clickstate == "1") {
                opac = "1";
            }
            return opac;
        });
        authorRect.transition()
                .duration(duration)
                .style("opacity", function(d, i) {

            var opac = "0.0";
            if (d.clickstate == "1") {
                opac = "1";
            }
            return opac;
        });

		undoHighlightAuthorsLinks();
        commentsList = [];

    }	
	
	function undohighlightTopicLinks() {	
	        vis.selectAll(".linktopics")
                .transition()
                .attr("opacity", function(d, i) {
					var opac = ".2";
					if(d.clickstate=="1") opac="1";
					return opac;
        });
	}
	function undoHighlightAuthorsLinks() {	
	        vis.selectAll(".linkauthors")
                .transition()
                //.duration(duration)
                .attr("opacity", function(d, i) {
            return "0.3";
        });
	}

	function updateAuthorSelector(selectedOpacity){
		authorSelector.transition()
                .duration(duration)
                .style("opacity", function(d, i) {
					var op = "0";
					if(d.clickAuthor=="1"){	
						op=selectedOpacity;
					}							
					return op;
        });		
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
			
				<div id="div_title" > 
				

				 </div align="right">
					<div id="content">

					</div>
                    <div id="test">


                    </div>

                </td>
            </tr>
        </table>
    </body>
</html>