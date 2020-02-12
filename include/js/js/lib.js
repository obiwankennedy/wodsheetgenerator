/*  Bibliothèque JavaScript version 0.1
 *  Autor: Renaud Guezennec
 *
 * 
 * 
 *
*/

function isNumberKey(evt)
{
 var charCode = (evt.which) ? evt.which : event.keyCode
 if (charCode > 31 && (charCode < 48 || charCode > 57))
	return false;

 return true;
}


function search()
				{	
					var keyword = $F("motcles");
					
					if(keyword.length < 2)
						{
							alert("le terme de recherche doit contenir plus de 3 caractères");
								return false;
						}
						else
						{
							Element.update("main","recherche en cours");
							new Ajax.Updater("main","search/index.php",{parameters:{keyword: keyword}});
						}
				}

function affiche_identification()
		{
			new Ajax.Updater("main","connexion/index.php",{parameters:{partie: "main"}});


			
		}
function refreshContent()
{
	//new Ajax.Updater("middle","/refreshContent.php",{parameters:$('general').serialize(true)});

                $.ajax({
                            url: "/refreshContent.php",
                            type: "POST",
                            data: $('#general').serialize()
                            }).done(function(msg) {
                                $('#middle').html(msg);
                            });

}
function authentification()
	{
		var login = $F("login");
		var password = $F("mdp");
		if((login.length ==0 )||(password.length ==0 ))
						{
							alert("Vous avez saisie des informations vides");
								return false;
						}
						else
						{
							/*new Ajax.Updater("authentification","connexion/index.php",{parameters:{partie: "tete",login: login,password: password}});
							new Ajax.Updater("main","display/accueil.php");*/
							return true;
						}
		
	}
function display_command(id_cmd)
{
	new Ajax.Updater("contenu","display/index.php",{parameters:{id_cmd: id_cmd}});
}
function display_the_command(id)
{
	new Ajax.Updater("cmd"+id,"display/index.php",{parameters:{id: id}});
}
function display_short_command(rat)
{
	//alert("j'ai quitté le survole de "+rat);
	new Ajax.Updater("cmd"+rat,"display/index.php",{parameters:{rat: rat}});
}
function show_administration()
{
	new Ajax.Updater("main","admin/index.php");
}
function show_admin_form()
{
	var choise = $F("choix");
	new Ajax.Updater("form","admin/index.php",{parameters:{choise: choise}});
}
function show_form_one(id)
{
	var choise = $F("choix");
	new Ajax.Updater("form","admin/index.php",{parameters:{choise: choise,id:id}});
}
function usersso()
{
	var nom = $F("nom");
	var login = $F("login");
	var prenom = $F("prenom");
	var email= $F("email");
	var motdepasse= $F("motdepasse");
	var confir= $F("confmdp");
	var action = $F("action");
	
	
	if((password.length ==0 )||(confir != motdepasse))
	{
		alert("Les mots de passes ne sont pas identiques");
					return false;
	}
	else
	new Ajax.Updater("form","admin/userso.php",{parameters:{login:login,action:action,nom: nom,prenom: prenom,email:email,motdepasse:motdepasse,confir:confir}});
}
function osso()
{
	var nom = $F("titre");
	var action = $F("action");
	new Ajax.Updater("form","admin/osso.php",{parameters:{titre:titre,action:action}});
}
function cmdso()
{
	var titre = $F("titre");
	return true;
}
function home()
{

new Ajax.Updater("main","display/accueil.php");
	
}
function erreur()
{
	Element.update("main","recherche en cours");
}
function catso()
{
	
	return true;
}
function bonmail(str)
{
        var at="@"
        var dot="."
        var lat=str.indexOf(at)
        var lstr=str.length
        var ldot=str.indexOf(dot)
        if (str.indexOf(at)==-1){
           
           return false
        }

        if (str.indexOf(at)==-1 || str.indexOf(at)==0 || str.indexOf(at)==lstr){
           
           return false
        }

        if (str.indexOf(dot)==-1 || str.indexOf(dot)==0 || str.indexOf(dot)==lstr){
            
            return false
        }

         if (str.indexOf(at,(lat+1))!=-1){
            
            return false
         }

         if (str.substring(lat-1,lat)==dot || str.substring(lat+1,lat+2)==dot){
            
            return false
         }

         if (str.indexOf(dot,(lat+2))==-1){
            
            return false
         }
        
         if (str.indexOf(" ")!=-1){
            
            return false
         }

         return true                    
    
}

function inscriptionso()
{
    var nom = $F("nom");
    var login = $F("login");
    var prenom = $F("prenom");
    var email= $F("email");
    var motdepasse= $F("motdepasse");
    var confir= $F("confmdp");
    var action = $F("action");
    if((motdepasse.length ==0 ))
    {
        alert("Les mots de passes sont vide");
     
                    return false;
    }
    if(false==bonmail(email))
    {
        alert("email pas bon");
     
                    return false;
    }
    
    if((confir != motdepasse))
    {
        alert("Les mots de passes ne sont pas identiques");
                    return false;
    }
    else
    new Ajax.Updater("main","connexion/inscription.php",{parameters:{login:login,action:action,nom: nom,prenom: prenom,email:email,motdepasse:motdepasse,confir:confir}});
}
function letter(lettre)
{
	new Ajax.Updater("contenu","display/lettre.php",{parameters:{lettre: lettre}});
}
function faq()
{
    new Ajax.Updater("main","contenu/faq.php");
}
function erreur()
{
	
}
function show_profile()
{
    new Ajax.Updater("main","connexion/inscription.php");
}
function affiche_inscription()
{
 new Ajax.Updater("main","connexion/inscription.php");
}
function contact()
{
	new Ajax.Updater("main","contenu/contact.php");
}
function courriel()
{
	new Ajax.Updater("main","contenu/contact.php");
}
function disconnect()
{
    new Ajax.Updater("contenu","session/deco.php");
    new Ajax.Updater("authentification","connexion/index.php");
    new Ajax.Updater("main","display/accueil.php");
}
function show_Cat(CAT_SELECT)
{
    
    new Ajax.Updater("contenu","display/catos.php",{parameters:{CAT_SELECT:CAT_SELECT}});

}
function  show_OS(OS_SELECT)
{
    
    new Ajax.Updater("contenu","display/catos.php",{parameters:{OS_SELECT:OS_SELECT}});

}
