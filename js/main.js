// Possible color families
colorFamily = [
	["241,89,95", "121,195,106", "89,154,211", "249,166,90", "158,102,171"],
	["205,112,88", "89,154,211", "241,89,95", "215,127,179", "121,195,106", "230, 171, 2"],
	["205,112,88", "89,154,211", "121,195,106", "158,102,171", "241,89,95"],
	["241, 89,95", "121,195,106", "249,166,90", "215,127,179", "205,112,88"],
	["249,166,90", "205,112,88", "89,154,211", "215,127,179", "121,195,106"],
	["205,112,88", "121,195,106", "215,127,179", "89,154,211", "241, 89,95"]
]; 

sentimentColors=[
	"215, 25, 28",
	//"253, 174, 97",
	"239, 165, 165",
	"255, 255, 191",
	"166, 217, 106",
	"26, 150, 65"
	];
var w = 1000,
    h = 3000,
    i = 0,
    barHeight = 16,
    barWidth = w * .25,
    duration = 400,
    root,
	minimumbarHeight=4,
	maximumbarHeight=40;
var arcRad=250, arcCx=barWidth/2, arcCy=200,angleInDegrees=15;
var radius = 5, gap = 50;

var tree = d3.layout.tree()
    .size([h, 25]);

var diagonal = d3.svg.diagonal()
    .projection(function(d) { return [d.y, d.x]; });

var topicDiagonal = d3.svg.diagonal()
    .projection(function(d) { return [d.y, d.x]; });
	
var vis = d3.select("#chart").append("svg:svg")
    .attr("width", w)
    .attr("height", h)
  .append("svg:g")	
    .attr("transform", "translate(300,30)");

d3.json("article10_02_16_1814217.json", function(json) {
  json.x0 = 0;
  json.y0 = 0;
  update(root = json);
});

var topicList=[];
var topicLinks=[];
var authorList=[];
var authorLinks=[];
var threadStructureHeight=0;
	
function update(source) {


  // Compute the flattened node list. TODO use d3.layout.hierarchy.
	var nodes = tree.nodes(root);
	var commentHeight=new Array();
	var topicShift=0;
	angleInDegrees=130/root.topics.length; //Dont want to use full 180 degree

	// compute comment height, topic shift and extractive keyphrase
	for(i=0; i<nodes.length;i++){
		commentHeight[i]=findCommentHeight(nodes[i]);		
		threadStructureHeight+=commentHeight[i];
		if(i>0){
			if(nodes[i-1].sent[nodes[i-1].sent.length-1].systemtopicid==nodes[i].sent[0].systemtopicid)	
				nodes[i].topicShift=1;
			else topicShift=0;
		}
		
		//find Keyphrase
		var commentPhrase="";
		for(j=0;j<root.topics.length;j++){
			for(s=0;s<nodes[i].sent.length;s++){		
				if(root.topics[j].topicID==nodes[i].sent[s].systemtopicid)
				{
					for(k=0;k<root.topics[j].labels.length;k++){
							 var words=root.topics[j].labels[k].phrase.split(" "); 
							 for (w=0;w<words.length;w++){
															 
							if(nodes[i].sent[s].sent.indexOf(words[w])>=0)
								if(commentPhrase.indexOf(words[w])<0)
									commentPhrase+=words[w]+" ";
							}	
						}
					
					
				}
			}
			nodes[i].keyPhrase=commentPhrase;		
		}
		
	}
	
  // Compute the "layout".
  nodes.forEach(function(n, i) {
	height=0;	
  	for(j=0; j<i;j++){
		height+=commentHeight[j];
	}
	n.x = height;
  });
	
	
	arcCy=threadStructureHeight/2;
	arcRad=threadStructureHeight/2;
	//store the list of topics into an array
	
	var startAngle=120;
	for(j=0;j<root.topics.length;j++){
		
		var topicName=root.topics[j].labels[0].phrase;
		var angle=startAngle+angleInDegrees*j;
		var coordx=(arcRad * Math.cos((startAngle+angleInDegrees*j) * Math.PI / 180)) + arcCx;
		var coordy=(arcRad * Math.sin((startAngle+angleInDegrees*j)* Math.PI / 180)) + arcCy;
				
		topicList.push({topicID:root.topics[j].topicID,name: ""+topicName,x: coordx,y: coordy,angle:angle, col:"rgb(0, 71, 157)", type:"topic" });
	}

	//linking topics with comments
	nodes.forEach(function(n, i) {
		for(j=0;j<topicList.length;j++){
			//alert(n.sent.length);
			for(k=0;k<n.sent.length;k++){				
				if(topicList[j].topicID==n.sent[k].systemtopicid)
				{					
					topicLinks.push({source:{x:topicList[j].y,y:topicList[j].x, topic: n.sent[k].systemlabel},target: {x:n.x,y:n.y, topic: n.sent[k].systemlabel,}});
					break;
				}	
			}
		}
	});	
	
	//create list of authors and linking authors with comments
	//arcCx=200;
	var NumberofAuthorsTobeShown=11;
	var angleInDegreesAuthors=130/NumberofAuthorsTobeShown; //Dont want to use full 180 degree
	for (i=0;i<nodes.length;i++){		
		if(i<NumberofAuthorsTobeShown){
		var startAngle=-60;
		var angle=startAngle+angleInDegrees*i;
		var coordx=(arcRad * Math.cos((startAngle+angleInDegreesAuthors*i) * Math.PI / 180)) + arcCx;
		var coordy=(arcRad * Math.sin((startAngle+angleInDegreesAuthors*i)* Math.PI / 180)) + arcCy;					
		authorList.push({name:nodes[i].author, x: coordx, y: coordy,col:"rgb(152, 78, 163)",type:"author" });
		//authorList.push({name:nodes[i].author, x: coordx, y: coordy,col:"rgb(255, 127, 0)",type:"author" });
		authorLinks.push({source:{x:coordy,y:coordx,author: nodes[i].author},target: {x:nodes[i].x,y:nodes[i].y+barWidth,author: nodes[i].author}});
		}
	}
	

  // Update the nodes…
  var node = vis.selectAll("g.node")
      .data(nodes, function(d) { return d.id || (d.id = ++i); });
  
  var nodeEnter = node.enter().append("svg:g")
      .attr("class", "node")
      .attr("transform", function(d) { return "translate(" + source.y0 + "," + source.x0 + ")"; })
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
	  nodeEnter.append("svg:rect")
		  .attr("y", -barHeight / 2)
		  .attr("height", findCommentHeight)
		  .attr("width", function (d){
			colorBins=color(d);
			return barWidth;
		  })
		  .style("fill", "rgb("+sentimentColors[0]+")")
		  .on("click", click);

	  nodeEnter.append("svg:rect")
		  .attr("y", -barHeight / 2)
		  .attr("height", findCommentHeight)
		  .attr("width", function (d){
			colorBins=color(d);
			return barWidth-(barWidth*colorBins[0]);
		  })
		  .style("fill", "rgb("+sentimentColors[1]+")")
		  .on("click", click);	
		  
	  nodeEnter.append("svg:rect")
		  .attr("y", -barHeight / 2)
		  .attr("height", findCommentHeight)
		  .attr("width", function (d){
			colorBins=color(d);
			return  barWidth-(barWidth*colorBins[0]+barWidth*colorBins[1]);
		  })
		  .style("fill", "rgb("+sentimentColors[2]+")")
		  .on("click", click);		

	  nodeEnter.append("svg:rect")
		  .attr("y", -barHeight / 2)
		  .attr("height", findCommentHeight)
		  .attr("width", function (d){
			colorBins=color(d);

			return  barWidth-(barWidth*colorBins[0]+barWidth*colorBins[1]+barWidth*colorBins[2]);
		  })
		  .style("fill", "rgb("+sentimentColors[3]+")")
		  .on("click", click);

	  nodeEnter.append("svg:rect")
		  .attr("y", -barHeight / 2)
		  .attr("height", findCommentHeight)
		  .attr("width", function (d){
			colorBins=color(d);
			return  barWidth-(barWidth*colorBins[0]+barWidth*colorBins[1]+barWidth*colorBins[2]+barWidth*colorBins[3]);
		  })
		  .style("fill", "rgb("+sentimentColors[4]+")")
		  .on("click", click);

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
      .attr("transform", function(d) { return "translate(" + d.y + "," + d.x + ")"; })
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
      .attr("transform", function(d) { return "translate(" + source.y + "," + source.x + ")"; })
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
			.attr("opacity","0.3");			
	//var combine=topicList.concat(authorList);
    var circle = vis.selectAll(".circle")
            .data(topicList)
            .enter()
            .append("g")
            .attr("class", "circle")			
			.attr("fill", function(d){return d.col;});
    


    var circleTopics = circle.append("circle")
            .attr("cx", function(d) {return d.x;})
            .attr("cy", function(d) {return d.y;})
            .attr("r", radius)
			.append("title").text(function(d) {return d.name})
			
			
	var imgs = vis.selectAll("image").data(authorList);
    imgs.enter()
				.append("svg:image")
				.attr("x", function(d) {return d.x-10;})
				.attr("y", function(d) {return d.y-8;})				
                .attr("xlink:href", "icons/author.png")
                .attr("width", "14")
                .attr("height", "15")
				.attr("opacity", ".5");	

	var textAuthor = vis.selectAll("text").data(authorList);
	textAuthor.enter()
		.append("svg:text")		
		.attr("transform", function(d) { 		
			return "translate(" + 12+ ")"; 
		})
		.attr("x", function(d) {return d.x; })
		.attr("y", function(d) { return d.y; })
		.attr("dy", ".35em") // vertical-align
		.attr("fill", function(d) { return d.col; }) // vertical-align
		.text(function(d) { return d.name; });

	var text = circle.append("text")
	.attr("transform", function(d) {
		if(d.type=="topic") 
			return "translate(" + (-(d.name.length*8.25))+ ")"; 
		else return "translate(" + 10+ ")"; 
	})
    .attr("x", function(d) {return d.x; })
	.attr("y", function(d) { return d.y; })
    .attr("dy", ".35em") // vertical-align
    .text(function(d) { return d.name; });
			   
	vis.selectAll("image")
		.on("mouseover", function(d) {
		    aut=d.name;
			
			vis.selectAll(".linkauthors")
			   .transition()
               //.duration(duration)
               .attr("opacity", function(d,i){
					if(d.target.author==aut) return "1";
					else return "0.3";
			   });
            d3.select(this)
			   .transition()
               .duration(duration)
               .attr("opacity", "1");
        });
		
	vis.selectAll("image")
		.on("mouseout", function(d) {
 			vis.selectAll(".linkauthors")
			   .transition()
               //.duration(duration)
               .attr("opacity", function(d,i){
 					return "0.3";
			   });
            d3.select(this)
			   .transition()
               .duration(duration)
               .attr("opacity", ".5");			   
         });	

		 
    var testCircle = circle.append("circle")
            .attr("cx", arcCx)
            .attr("cy", arcCy)
            .attr("r", radius)
			.style("fill", "red");	
	
	vis.selectAll(".circle")
		.on("mouseover", function(d) {
		    topicName=d.name;			
			vis.selectAll(".linktopics")
			   .transition()
               .attr("opacity", function(d,i){					
			        var opac=".2";
					if(d.source.topic==topicName) opac="1";
					return opac;
			   });
            d3.select(this)
			   .transition()
               .duration(duration)
               .attr("opacity", ".3");
        });

	vis.selectAll(".circle")
		.on("mouseout", function(d) {
		    topicName=d.name;			
			vis.selectAll(".linktopics")
			   .transition()
               .attr("opacity", function(d,i){					
			        var opac=".2";
					return opac;
			   });
            d3.select(this)
			   .transition()
               .duration(duration)
               .attr("opacity", ".3");
        });
		
	
  // Stash the old positions for transition.
  nodes.forEach(function(d) {
    d.x0 = d.x;
    d.y0 = d.y;
  });
}

// Toggle children on click.
function click(d) {
  if (d.children) {
    d._children = d.children; //collapsed-> d._children
    d.children = null;
  } else {
    d.children = d._children;
    d._children = null;
  }
  update(d);
}

function color(d) {
  //return d._children ? "#3182bd" : d.children ? "#c6dbef" : "#fd8d3c";
  //return d._children ? "#c6dbef" : d.children ? "#ffffff" : "#ffffff";

//alert("hello world");
  
  var colorbins=new Array();
  colorbins[0]=0;
  colorbins[1]=0;
  colorbins[2]=0;
  colorbins[3]=0;
  colorbins[4]=0;  
	for(i=0; i<d.sent.length;i++){
		if(d.sent[i].linePolarity<-1.99){
			colorbins[0]++;
		}
		else if(d.sent[i].linePolarity<0){
			colorbins[1]++;
		}
		else if(d.sent[i].linePolarity==0){
			colorbins[2]++;
		}
		else if(d.sent[i].linePolarity>1.99){
			colorbins[4]++;
		}		
		else if(d.sent[i].linePolarity>0){
			colorbins[3]++;
		}
    }
	for(i=0; i<colorbins.length;i++){
		colorbins[i]=colorbins[i]/d.sent.length;
	}
    selectedColor="rgb(26, 150, 65)";
	if(d.sent[0].linePolarity<0){
		//selectedColor="rgb("+colorFamily[1][parseInt(d.sent[0].systemtopicid)]+")";
		selectedColor="rgb(215, 25, 28)";
		
	}
 
	return colorbins;
	//return selectedColor;  
}
function opacity(d) {
  //return d._children ? "#3182bd" : d.children ? "#c6dbef" : "#fd8d3c";
  //return d._children ? "#c6dbef" : d.children ? "#ffffff" : "#ffffff";
	opacity=1;
	if(d.sent[0].systemtopicid<5){
		opacity=0.2;
	}
	return opacity;  
}
function findCommentHeight(d){
	if(d.sent.length*2<4) return minimumbarHeight;
	else if(d.sent.length*2>20) return maximumbarHeight;
	else return d.sent.length*2;
}

   