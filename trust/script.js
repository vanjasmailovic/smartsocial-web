////////////////////////////////////////////////////////////
//////////////////////// Set-up ////////////////////////////
////////////////////////////////////////////////////////////
var screenWidth = $(window).width(),
        mobileScreen = (screenWidth > 400 ? false : true);

var w = 1100; // radijus
var margin = {left: 50, top: 10, right: 50, bottom: 10};
var width = Math.min(screenWidth, w) - margin.left - margin.right;
var height = (mobileScreen ? 300 : Math.min(screenWidth, w) * 5 / 6) - margin.top - margin.bottom;

var svg = d3.select("#chart").append("svg")
        .attr("width", (width + margin.left + margin.right))
        .attr("height", (height + margin.top + margin.bottom));

var wrapper = svg.append("g").attr("class", "chordWrapper")
        .attr("transform", "translate(" + (width / 2 + margin.left) + "," + (height / 2 + margin.top) + ")");


var outerRadius = Math.min(width, height) / 2 - (mobileScreen ? 80 : 100),
        innerRadius = outerRadius * 0.95,
        pullOutSize = (mobileScreen ? 20 : 50),
        opacityDefault = 0.7, //default opacity of chords
        opacityLow = 0.02; //hover opacity of those chords not hovered over


//////////////////////////////////////////////////////
//////////////////// Colors ///////////////////
//////////////////////////////////////////////////////
var outerArcs1 = "#000";
var outerArcs2 = "#FF1654";
var innerChords1 = "#938267";
var innerChords2 = "#e08c1b";
var innerChords3 = "#c54803";
var innerChords4 = "";
var innerChords5 = "";


//
//////////////////////////////////////////////////////
//////////////////// Titles on top ///////////////////
//////////////////////////////////////////////////////

var titleWrapper = svg.append("g").attr("class", "chordTitleWrapper"),
        titleOffset = mobileScreen ? 15 : 40,
        titleSeparate = mobileScreen ? 30 : 0;

//Title	top left
titleWrapper.append("text")
        .attr("class", "title left")
        .style("font-size", mobileScreen ? "12px" : "16px")
        .attr("x", (width / 2 + margin.left - outerRadius - titleSeparate - 80))
        .attr("y", titleOffset)
        .text("Top Users (Facebook ID)");
titleWrapper.append("line")
        .attr("class", "titleLine left")
        .attr("x1", (width / 2 + margin.left - outerRadius - titleSeparate) * 0.6 - 50)
        .attr("x2", (width / 2 + margin.left - outerRadius - titleSeparate) * 1.4 + 50)
        .attr("y1", titleOffset + 8)
        .attr("y2", titleOffset + 8);
//Title top right
titleWrapper.append("text")
        .attr("class", "title right")
        .style("font-size", mobileScreen ? "12px" : "16px")
        .attr("x", (width / 2 + margin.left + outerRadius + titleSeparate - 50))
        .attr("y", titleOffset)
        .text("Data Type");
titleWrapper.append("line")
        .attr("class", "titleLine right")
        .attr("x1", (width / 2 + margin.left - outerRadius - titleSeparate) * 0.6 + 2 * (outerRadius + titleSeparate) -50)
        .attr("x2", (width / 2 + margin.left - outerRadius - titleSeparate) * 1.4 + 2 * (outerRadius + titleSeparate) + 50)
        .attr("y1", titleOffset + 8)
        .attr("y2", titleOffset + 8);
////////////////////////////////////////////////////////////
////////////////////////// Data ////////////////////////////
////////////////////////////////////////////////////////////

var emptyPerc = 0.8; //What % of the circle should become empty
var emptyStroke = Math.round(respondents * emptyPerc);

//Calculate how far the Chord Diagram needs to be rotated clockwise to make the dummy
//invisible chord center vertically
var offset = (2 * Math.PI) * (emptyStroke / (respondents + emptyStroke)) / 4;

//Custom sort function of the chords to keep them in the original order
function customSort(a, b) {
    return 1;
}

//Custom sort function of the chords to keep them in the original order
var chord = customChordLayout() //d3.layout.chord()//Custom sort function of the chords to keep them in the original order
        .padding(.02)
        .sortChords(d3.descending) //which chord should be shown on top when chords cross. Now the biggest chord is at the bottom
        .matrix(matrix);

var arc = d3.svg.arc()
        .innerRadius(innerRadius)
        .outerRadius(outerRadius)
        .startAngle(startAngle) //startAngle and endAngle now include the offset in degrees
        .endAngle(endAngle);

var path = stretchedChord()
        .radius(innerRadius)
        .startAngle(startAngle)
        .endAngle(endAngle);

////////////////////////////////////////////////////////////
//////////////////// Draw outer Arcs ///////////////////////
////////////////////////////////////////////////////////////

var g = wrapper.selectAll("g.group")
        .data(chord.groups)
        .enter().append("g")
        .attr("class", "group")
        .on("mouseover", fade(opacityLow))
        .on("mouseout", fade(opacityDefault));

g.append("path")
        .style("stroke", function (d, i) {
            var color = ((d.endAngle + 0.001) > Math.PI ? outerArcs1 : getColor(i));
            return (Names[i] === "" ? "none" : color);
        })
        .style("fill", function (d, i) {
            var color = ((d.endAngle + 0.001) > Math.PI ? outerArcs1 : getColor(i));
            return (Names[i] === "" ? "none" : color);
        })
        .style("pointer-events", function (d, i) {
            return (Names[i] === "" ? "none" : "auto");
        })
        .attr("d", arc)
        .attr("transform", function (d, i) { //Pull the two slices apart
            d.pullOutSize = pullOutSize * ((d.endAngle + 0.001) > Math.PI ? -1 : 1); //Math.PI
            return "translate(" + d.pullOutSize + ',' + 0 + ")";
        });

function getColor(i) {
        i = (i+1973) * 99737;
        console.log("["+i+"] "+i.toString(16).substr(0,6));
        return "#" + i.toString(16).substr(0,6);
}

////////////////////////////////////////////////////////////
////////////////////// Append Names ////////////////////////
////////////////////////////////////////////////////////////

//The text also needs to be displaced in the horizontal directions
//And also rotated with the offset in the clockwise direction
g.append("text")
        .each(function (d) {
            d.angle = ((d.startAngle + d.endAngle) / 2) + offset;
        })
        .attr("dy", ".35em")
        .attr("class", "titles")
        .attr("text-anchor", function (d) {
            return d.angle > Math.PI ? "end" : null;
        })
        .attr("transform", function (d, i) {
            var c = arc.centroid(d);
            return "translate(" + (c[0] + d.pullOutSize) + "," + c[1] + ")"
                    + "rotate(" + (d.angle * 180 / Math.PI - 90) + ")"
                    + "translate(" + 55 + ",0)"
                    + (d.angle > Math.PI ? "rotate(180)" : "")
        })
        .text(function (d, i) {
            return Names[i];
        })
        .call(wrapChord, 100);

////////////////////////////////////////////////////////////
//////////////////// Draw inner chords /////////////////////
////////////////////////////////////////////////////////////

var chords = wrapper.selectAll("path.chord")
        .data(chord.chords)
        .enter().append("path")
        .attr("class", "chord")
        .style("stroke", "none")
        .style("fill", function (d) {
            return getColor(d.target.subindex);
        })
        .style("opacity", function (d) {
            return (Names[d.source.index] === "" ? 0 : opacityDefault);
        }) //Make the dummy strokes have a zero opacity (invisible)
        .style("pointer-events", function (d, i) {
            return (Names[d.source.index] === "" ? "none" : "auto");
        }) //Remove pointer events from dummy strokes
        .attr("d", path)
        .on("mouseover", fadeOnChord)
        .on("mouseout", fade(opacityDefault));

////////////////////////////////////////////////////////////
///////////////////////// Tooltip //////////////////////////
////////////////////////////////////////////////////////////

//Arcs
g.append("title")
        .text(function (d, i) {
            return Math.round(d.value) + " total score " + Names[i];
        });

//Chords
chords.append("title")
        .text(function (d) {
            return [Math.round(d.source.value), " score from ", Names[d.target.index], " to ", Names[d.source.index]].join("");
        });

////////////////////////////////////////////////////////////
////////////////// Extra Functions /////////////////////////
////////////////////////////////////////////////////////////

//Include the offset in de start and end angle to rotate the Chord diagram clockwise
function startAngle(d) {
    return d.startAngle + offset;
}
function endAngle(d) {
    return d.endAngle + offset;
}

// Returns an event handler for fading a given chord group
function fade(opacity) {
    return function (d, i) {
        wrapper.selectAll("path.chord")
                .filter(function (d) {
                    return d.source.index != i && d.target.index != i && Names[d.source.index] != "";
                })
                .transition()
                .style("opacity", opacity);
    };
}//fade

// Fade function when hovering over chord
function fadeOnChord(d) {
    var chosen = d;
    wrapper.selectAll("path.chord")
            .transition()
            .style("opacity", function (d) {
                if (d.source.index == chosen.source.index && d.target.index == chosen.target.index) {
                    return opacityDefault;
                } else {
                    return opacityLow;
                }//else
            });
}//fadeOnChord

//Taken from http://bl.ocks.org/mbostock/7555321
//Wraps SVG text
function wrapChord(text, width) {
    text.each(function () {
        var text = d3.select(this),
                words = text.text().split(/\s+/).reverse(),
                word,
                line = [],
                lineNumber = 0,
                lineHeight = 1.1, // ems
                y = 0,
                x = 0,
                dy = parseFloat(text.attr("dy")),
                tspan = text.text(null).append("tspan").attr("x", x).attr("y", y).attr("dy", dy + "em");

        while (word = words.pop()) {
            line.push(word);
            tspan.text(line.join(" "));
            if (tspan.node().getComputedTextLength() > width) {
                line.pop();
                tspan.text(line.join(" "));
                line = [word];
                tspan = text.append("tspan").attr("x", x).attr("y", y).attr("dy", ++lineNumber * lineHeight + dy + "em").text(word);
            }
        }
    });
}//wrapChord