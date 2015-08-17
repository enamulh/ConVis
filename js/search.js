
		
			$(function() {

				var self = this;
				self.input = $("#search").select().focus();
				
			    //handles searching the document
				self.performSearch = function() {

					//create a search string
					var phrase = self.input.val().replace(/^\s+|\s+$/g, "");					
					phrase = phrase.replace(/\s+/g, "|");
					
					//make sure there are a couple letters
					if (phrase.length < 3) { return; }			
					
					//append the rest of the expression
					phrase = ["\\b(", phrase, ")"].join("");
					
					//search for any matches
					var count = 0;
					$("h1, h3, p").each(function(i, v) {
					
						//replace any matches
						var block = $(v);
						block.html(
							block.text().replace(
								new RegExp(phrase, "gi"), 
								function(match) {
									count++;
									return ["<span class='highlight'>", match, "</span>"].join("");
								}));
						
					});
					
					//update the count
					$(".result-count").text(count + " results on this page!");
					
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
			
			});
		