// Milonic DHTML Menu
// Please note that major changes to this file have been made and is not compatible with earlier versions..
//
// You no longer need to number your menus as in previous versions. 
// The new menu structure allows you to name the menu instead. This means that you can remove menus and not break the system.
// The structure should also be much easier to modify, add & remove menus and menu items.
// 
// If you are having difficulty with the menu please read the FAQ at http://www.milonic.co.uk/menu/faq.php before contacting us.
//
// Please note that the above text CAN be erased if you wish as long as copyright notices remain in place.


// The following line is critical for menu operation, and must appear only once.
menunum=0;menus=new Array();_d=document;function addmenu(){menunum++;menus[menunum]=menu;}function dumpmenus(){mt="<scr"+"ipt language=javascript>";for(a=1;a<menus.length;a++){mt+=" menu"+a+"=menus["+a+"];"}mt+="<\/scr"+"ipt>";_d.write(mt)}
//Please leave the above line intact. The above also needs to be enabled if it not already enabled


////////////////////////////////////
// Editable properties START here //
////////////////////////////////////

timegap=500					// The time delay for menus to remain visible on mouse off
followspeed=30				// Follow Scrolling speed (higher number makes the scrolling smoother but slower)
followrate=40				// Follow Scrolling Rate (use a minimum of 40 or you may experience problems)
suboffset_top=6;			// Sub menu offset Top position 
suboffset_left=0;			// Sub menu offset Left position

// Special effect string for IE5.5 or above please visit http://www.milonic.co.uk/menu/filters_sample.php for more filters
if(navigator.appVersion.indexOf("MSIE 6.0")>0)
{
	effect = "Fade(duration=0.5);Alpha(style=0,opacity=92);Shadow(color='#777777', Direction=135, Strength=5)"
}
else
{
	effect = "Shadow(color='#777777', Direction=135, Strength=5);"
}

main=[						// main is an array of properties. You can have as many property arrays as you need. This means that menus can have their own style.
"white",					// Mouse Off Font Color
"silver",					// Mouse Off Background Color
"333366",					// Mouse On Font Color
"silver",					// Mouse On Background Color
"Silver",					// Menu Border Color 
11,							// Font Size (default is px but you can specify mm, pt or a percentage)
"normal",					// Font Style (italic or normal)
"normal",						// Font Weight (bold or normal)
"Tahoma",	// Font Name
0,							// Menu Item Padding
"",							// Sub Menu Image (Leave this blank if not needed)
,							// 3D Border & Separator bar
"66ffff",					// 3D High Color
"000099",					// 3D Low Color
"Purple",					// Current Page Item Font Color (leave this blank to disable)
"pink",						// Current Page Item Background Color (leave this blank to disable)
"",							// Top Bar image (Leave this blank to disable)
"ffffff",					// Menu Header Font Color (Leave blank if headers are not needed)
"000099",					// Menu Header Background Color (Leave blank if headers are not needed)
]



style2=[					// style1 is an array of properties. You can have as many property arrays as you need. This means that menus can have their own style.
"white",					// Mouse Off Font Color
"0F1477",					// Mouse Off Background Color
"black",					// Mouse On Font Color
"FFCC00",					// Mouse On Background Color
"F7F7F7",					// Menu Border Color 
11,							// Font Size (default is px but you can specify mm, pt or a percentage)
"normal",					// Font Style (italic or normal)
"normal",					// Font Weight (bold or normal)
"Tahoma",	// Font Name
3,							// Menu Item Padding
"",// Sub Menu Image (Leave this blank if not needed)
"",							// 3D Border & Separator bar
"",							// 3D High Color
"",							// 3D Low Color
"",							// Current Page Item Font Color (leave this blank to disable)
"",							// Current Page Item Background Color (leave this blank to disable)
"",							// Top Bar image (Leave this blank to disable)
"",							// Menu Header Font Color (Leave blank if headers are not needed)
"",							// Menu Header Background Color (Leave blank if headers are not needed)
]


addmenu(menu=[		// This is the array that contains your menu properties and details
"mainmenu",			// Menu Name - This is needed in order for the menu to be called
80,					// Menu Top - The Top position of the menu in pixels
5,					// Menu Left - The Left position of the menu in pixels
,					// Menu Width - Menus width in pixels
,					// Menu Border Width 
,					// Screen Position - here you can use "center;left;right;middle;top;bottom" or a combination of "center:middle"
main,				// Properties Array - this is set higher up, as above
1,					// Always Visible - allows the menu item to be visible at all time (1=on/0=off)
,					// Alignment - sets the menu elements text alignment, values valid here are: left, right or center
,					// Filter - Text variable for setting transitional effects on menu activation - see above for more info
,					// Follow Scrolling - Tells the menu item to follow the user down the screen (visible at all times) (1=on/0=off)
1, 					// Horizontal Menu - Tells the menu to become horizontal instead of top to bottom style (1=on/0=off)
,					// Keep Alive - Keeps the menu visible until the user moves over another menu or clicks elsewhere on the page (1=on/0=off)
,					// Position of TOP sub image left:center:right
,					// ..Now Obsolete..
,					// Right To Left - Used in Hebrew for example. (1=on/0=off)
,					// Open the Menus OnClick - leave blank for OnMouseover (1=on/0=off)
,					// ID of the div you want to hide on MouseOver (useful for hiding form elements)
,					// Reserved for future use
,					// Reserved for future use
,					// Reserved for future use
,"<img name=home src=/images/bt_home.gif width=23 height=23 border=0>","show-menu=home",,,0// "Description Text", "URL", "Alternate URL", "Status", "Separator Bar"
,"<img name=support src=/images/bt_support.gif width=59 height=23 border=0>","show-menu=support",,,0
,"<img name=downloads src=/images/bt_upgrades.gif width=116 height=23 border=0>","show-menu=upgrades",,,0
,"<img name=implementation src=/images/bt_implementation.gif width=97 height=23 border=0>","show-menu=implementation",,,0
,"<img name=training src=/images/bt_training.gif width=60 height=23 border=0>","show-menu=training",,,0
,"<img name=documents src=/images/bt_documents.gif width=131 height=23 border=0>","show-menu=documents",,,0
,"<img name=news src=/images/bt_prodserv.gif width=122 height=23 border=0>","show-menu=news",,,0
,"<img name=feedback src=/images/bt_feedback.gif width=67 height=23 border=0>","show-menu=feedback",,,0
,"<img name=contact src=/images/bt_contact.gif width=80 height=23 border=0>","show-menu=contact",,,0
])

addmenu(menu=["home","",,180,1,"",style2,,"left",effect,,,,,,,,,,,,
,"MySMS Home", "/extranet/index.php",,,1
,"SMSCorp.com", "http://www.firstamsms.com",,,1
])

addmenu(menu=["support","",,180,1,"",style2,,"left",effect,,,,,,,,,,,,
,"Online Support", "/extranet/support/online_support.php",,,1
,"Email SMS Customer Support", "mailto:software.support@smscorp.com",,,1
// ,"Centra&reg; Login", "https://eclassroom.firstam.net/main/User/GuestAttend.jhtml?s",,,1
// ,"Download Centra&reg; Client Software", "/centra_download.php",,,1
,"Product FAQ's", "/extranet/support/faqs.php",,,1
//,"Knowledgebase", "/coming_soon.php",,,1
, "Right Answers Right Now", rarnLink + " target=RightAnswers",,,1
])

addmenu(menu=["upgrades","",,180,1,"",style2,,"left",effect,,,,,,,,,,,,
,"Self-Service Upgrades", "/extranet/upgrades/software_upgrades.php",,,1
,"Schedule an Upgrade", "/extranet/upgrades/schedule_upgrade.php",,,1
])

//addmenu(menu=["implementation","",,180,1,"",style2,,"left",effect,,,,,,,,,,,,
//,"Implementation Tools", "/extranet/implementation/tools.php",,,1
//,"Installation Requirements", "/extranet/implementation/installation_requirements.php",,,1
//,"Customer Surveys", "/extranet/implementation/surveys.php",,,1
//,"Upload Documents & Logos", "/extranet/implementation/upload_documents.php",,,1
//])

addmenu(menu=["implementation","",,180,1,"",style2,,"left",effect,,,,,,,,,,,,
,"Implementation Tools", "/extranet/implementation/tools.php",,,1
,"Installation Requirements", "/extranet/implementation/installation_requirements.php",,,1
,"Upload Documents & Logos", "/extranet/implementation/upload_documents.php",,,1
])

addmenu(menu=["training","",,180,1,"",style2,,"left",effect,,,,,,,,,,,,
,"Self-paced & Interactive Tutorials", "/extranet/training/tutorials.php",,,1
,"Training Manuals", "/extranet/training/manuals.php",,,1
,"Supplemental Training Materials", "/extranet/training/supplemental_materials.php",,,1
,"Tips & Tricks", "/extranet/training/tips.php",,,1
,"Training Facilities", "/extranet/training/facilities.php",,,1
])

addmenu(menu=["documents","",,180,1,"",style2,,"left",effect,,,,,,,,,,,,
,"Documents", "/extranet/documents/documents.php",,,1
,"Logos", "/extranet/documents/logos.php",,,1
,"Check Samples", "/extranet/documents/checks.php",,,1
,"Reports", "/extranet/documents/reports.php",,,1
])

addmenu(menu=["news","",,180,1,"",style2,,"left",effect,,,,,,,,,,,,
,"Products & Services Catalog", "/extranet/news/newsletter.php",,,1
,"Join our Mailing List", "/extranet/news/mailing_list.php",,,1
])

addmenu(menu=["feedback","",,180,1,"",style2,,"left",effect,,,,,,,,,,,,
,"Request Product Info", "/extranet/feedback/product_request.php",,,1
,"Software Change Request", "/extranet/feedback/change_request.php",,,1
])

addmenu(menu=["contact","",,180,1,"",style2,,"left",effect,,,,,,,,,,,,
// ,"Management", "http://www.firstamsms.com/contact/management.php",,,1
// ,"Sales", "http://www.firstamsms.com/contact/index.php",,,1
,"SMS Customer Support", "/public/contact/helpdesk_sms.php",,,1
,"TrustLink Help Desk", "/public/contact/helpdesk_trustacct.php",,,1
,"1099 Help Desk", "/public/contact/helpdesk_1099.php",,,1
// ,"Webmaster", "mailto:support@calibermg.com",,,1
])


//////////////////////////////////
// Editable properties END here //
//////////////////////////////////
dumpmenus() // This must be the last line in this file
