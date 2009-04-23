/*
 * jQuery Plugin: DivCorners
 * http://www.roydukkey.com/divcorners
 *
 * Copyright (c) 2009 Rory Dueck
 *
 * Dual licensed under the MIT (http://www.opensource.org/licenses/mit-license.php)
 * and GPL (http://www.opensource.org/licenses/gpl-license.php) licenses.
 *
 * Date: 2009-04-01 (Wed, 01 Apr 2009)
 * Version: 1.0.0
 *
 * NOTE: Please report any improvements to roydukkey-at-gmail-dot-com.
 *       There are still many improvements that can me made to this
 *       script. Thanks to all in the open community.
 */ 
(function($){
dc = {
	dcCreate: function(s,e) {
//--
// A: Set All Defaults
		o = $.extend({
			imgPrefix: "/images/",
			fileType: ".gif",
			expand: 10,
			radius: 0,
			position: "inside",
			resize: ""
		},s);
//--
// Check Expand for Array
		o.e = $.isArray(o.expand) ?
			o.expand.length == 2 ?
				{t: o.expand[0], r: o.expand[1], b: o.expand[0], l: o.expand[1]} // input: [a,b]; output: [a,b,a,b]
			:
				{t: o.expand[0], r: o.expand[1], b: o.expand[2], l: o.expand[3]} // input: [a,b,c,d]; output: [a,b,c,d]
		:
			{t: o.expand, r: o.expand, b: o.expand, l: o.expand} // input: a; output: [a,a,a,a]
		;
//--
// Check Radius for Array
		o.r = $.isArray(o.radius) ?
			o.radius.length == 2 ? { // if value of radius <
				t: o.radius[0] > o.e.t ? o.radius[0]-o.e.t : 0,
				r: o.radius[1] > o.e.r ? o.radius[1]-o.e.r : 0,
				b: o.radius[0] > o.e.b ? o.radius[0]-o.e.b : 0,
				l: o.radius[1] > o.e.l ? o.radius[1]-o.e.l : 0 // input: [a,b]; output: [a,b,a,b]
			} : {
				t: o.radius[0] > o.e.t ? o.radius[0]-o.e.t : 0,
				r: o.radius[1] > o.e.r ? o.radius[1]-o.e.r : 0,
				b: o.radius[2] > o.e.b ? o.radius[2]-o.e.b : 0,
				l: o.radius[3] > o.e.l ? o.radius[3]-o.e.l : 0 // input: [a,b,c,d]; output: [a,b,c,d]
			}
		: {
			t: o.radius > o.e.t ? o.radius-o.e.t : 0,
			r: o.radius > o.e.r ? o.radius-o.e.r : 0,
			b: o.radius > o.e.b ? o.radius-o.e.b : 0,
			l: o.radius > o.e.l ? o.radius-o.e.l : 0 // input: a; output: [a,a,a,a]
		}
		;
// A: End
//--
// B: Create DC for Each Object in Call
		return this.each(function() {
			(g = $(this)).addClass("dCorner").css({
				"height": g.height(),
				"width": g.width()
			});
			( u = g.find(">.dcContent") ).css({ //Special for developers, shhh!
				"height": u.height(),
				"width": u.width()
			});
			if(o.resize != "") g.find(o.resize).each(function() { //Apply dcResize to child images
				$(this).load(function() {
					//console.log("woot");
					$(this).parents(".dCorner").dcResize("r")
				})
			});
			
			for(x in a=[["t","top"],["r","right"],["b","bottom"],["l","left"]]) {
				s = g.append("<div class='dcItem dc"+a[x][1]+"'><img src='"+o.imgPrefix+a[x][1]+o.fileType+"' /></div>")
					.find(">.dc"+a[x][1]);

				if(x!=1 && x!=3) {
// top and bottom
					o.position == "inside" ?
						s.css("margin-left", o.e.l+o.r.l)
							.width(g.innerWidth()-(o.r.l+o.e.l+o.r.r+o.e.r))
					:
						s.css(a[x][1], -eval("o.e."+a[x][0]))
							.css("margin-left", o.r.l)
							.width(g.innerWidth()-(o.r.l+o.r.r))
					;
					s.height(eval("o.e."+a[x][0]))
						.css("display", "block");
					
// corners
					for(y in b=[["l","left"],["r","right"]]) {
						c = g.append("<div class='dcItem dc"+a[x][1]+"-"+b[y][1]+"'><img src='"+o.imgPrefix+a[x][1]+"-"+b[y][1]+o.fileType+"' /></div>")
							.find(">.dc"+a[x][1]+"-"+b[y][1]);
						
						if(o.position != "inside")
							c.css(a[x][1], -eval("o.e."+a[x][0]))
								.css(b[y][1], -eval("o.e."+b[y][0]));
						
						c.height(eval("o.e."+a[x][0])+eval("o.r."+a[x][0]))
							.width(eval("o.e."+b[y][0])+eval("o.r."+b[y][0]))
							.css("display", "block");
						
						png(c)
					}
				} else {
// right and left
					o.position == "inside" ?
						s.css("margin-top", o.e.t+o.r.t)
							.height(g.innerHeight()-(o.r.t+o.e.t+o.r.b+o.e.b))
					:
						s.css(a[x][1], -eval("o.e."+a[x][0]))
							.css("margin-top", o.r.t)
							.height(g.innerHeight()-(o.r.t+o.r.b))
					;
					s.width(eval("o.e."+a[x][0]))
						.css("display", "block")
				}
				png(s)
			}
			widthFix(g);
			if(e != false) g.parents(".dCorner").dcResize("r")
		}
// B: End
//--
	)},
	
	dcResize: function(e) {
//--
// C: Resize for Each Object in Call
		return this.each(function() {
			if(
				( g = $(this) ).hasClass("dCorner")
			) {
				g.css("zoom", "0");
				
				if(e == "r")
					g.css({"height": "", "width": ""});
				
				g.find(">.dctop,>.dcbottom")
					.width(
						g.innerWidth() - (
							( c=g.find(">.dctop-left") ).width() + parseInt( c.css("left").replace("px") ) +
							( d=g.find(">.dctop-right") ).width() + parseInt( d.css("right").replace("px") )
						)
					);
				g.find(">.dcleft,>.dcright")
					.height(
						g.innerHeight() - (
							c.height() + parseInt( c.css("top").replace("px") ) + 
							( d = g.find(">.dcbottom-left") ).height() + parseInt( d.css("bottom").replace("px") )
						)
					);
				
				widthFix(g);
				if(e == "r")
					g.css({"height": g.height(), "width": g.width()});
				
				g.css("zoom", "1");
				if(e != false) g.parents(".dCorner").dcResize("r")
			}
		}
// C: End
//--
	)},
//--
// D: Resize for Each Object in Call	
	dcClear: function(e) {
		return this.each(function() {
			$(this).removeClass("dCorner")
				.find(">.dcItem")
				.remove();
				
			if(e!=false) $(this).parents(".dCorner").dcResize("r")
		}
// D: End
//--
	)}
};

//--
// E: jQuery Plugin Init and Private Functions
$.each(dc, function(i) {
	$.fn[i] = this
});

function png(p) {
	if($.browser.msie && o.fileType == ".png") {
		p.css("filter", "progid:DXImageTransform.Microsoft.AlphaImageLoader(src='" +
			( i = $(p).find("img") ).attr("src") + "',sizingMethod='scale')");
		i.css("filter", "alpha(opacity=0)")
	}
}
function widthFix(c) {
// this is use to compensated for ie6's miscalculation
// of percent width and actual width
	if($.browser.version < 7.0 && $.browser.msie) {
		c.find(">.dctop-right,>.dcright,>.dcbottom-right")
			.css("margin-right", c.innerWidth()%2 != 0 ? "-1px" : "0px");
		c.find(">.dcbottom-left,>.dcbottom,>.dcbottom-right")
			.css("margin-bottom", c.innerHeight()%2 != 0 ? "-1px" : "0px" )
	}
}
})(jQuery);