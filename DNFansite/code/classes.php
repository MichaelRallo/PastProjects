<?php
	session_start();

    include("dbConnect.php");
    secureMe();
    $dbconn = null;
    $dbconn = connectDB($dbconn);	
?>

<!DOCTYPE html>
<html lang="en" class="no-js demo5">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
		<title>Final Project</title>
    	<script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
    	<script type="text/javascript" src="js/bootstrap.min.js"></script>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

        
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
		<link rel="stylesheet" type="text/css" href="css/style.css" />
		<link rel="stylesheet" type="text/css" href="css/styleClasses.css" />

	</head>
	<body>
	  <div id="wrapper">
        <div id="banner">
            <div align = "right">  
                <a href="index.php"><img src="images/logo5.png" alt="Logo" id="logo"></a>
                <?php $username = handleSignIn($dbconn); ?>
            </div>
        </div>
        <div class="menu">
				<a href="index.php" >Home</a>
				<a href="guides.php">Guides</a>
				<a href="classes.php" class="active">Classes</a>
				<a href="skillBuilds.php">Skill Builds</a>
				<a href="music.php">Music</a>
        </div>
        <div  id="content">
           <div id="classesContainer">
                <a href="classes.php?classSelectionChoice=warrior"><div id="warrior" class="classSelection"></div></a>
                <a href="classes.php?classSelectionChoice=archer"><div id="archer" class="classSelection"></div></a>
                <a href="classes.php?classSelectionChoice=cleric"><div id="cleric" class="classSelection"></div></a>
                <a href="classes.php?classSelectionChoice=sorceress"><div id="sorceress" class="classSelection"></div></a>
                <a href="classes.php?classSelectionChoice=tinker"><div id="tinker" class="classSelection"></div></a>
                <a href="classes.php?classSelectionChoice=kali"><div id="kali" class="classSelection"></div></a>
                <a href="classes.php?classSelectionChoice=assassin"><div id="assassin" class="classSelection"></div></a>
                <a href="classes.php?classSelectionChoice=lencea"><div id="lencea" class="classSelection"></div></a>       
           </div>
            </div><br>
            <div id="classDescription" class="group">
            <?php
            $classSelectionChoice = "";
            if(htmlspecialchars(isset($_GET['classSelectionChoice'])))
            $classSelectionChoice = htmlspecialchars($_GET['classSelectionChoice']);
            
            switch($classSelectionChoice){
                case 'warrior':
                    print("<h1>The Warrior!</h1>");
                    print("<div id=\"tab-body\" style=\"display: block;\"><h2>Warrior</h2><img class=\"fr\" alt=\"\" src=\"http://nxcache.nexon.net/dn/img/guide/class-guide/character-warrior.jpg\"> 
                    <p class=\"mb20\">As a Warrior you will battle foes in fast-paced close-ranged melee combat. Quick and agile, you will rely on melee combos to triumph over your foes.</p>
                    <h3>Character</h3>
                    <p class=\"mb20\">At heart, the Warrior is an optimist. He believes in keeping his weapons sharp and his wits sharper. Fond of crude jokes, he sometimes comes across as an uncultured brute, but in battle, he's clever and precise, relying on both raw strength and quick combos to gain the upper hand. Such an attitude is surprising considering his upbringing. His mother was killed by monsters, and his drill sergeant of a father walked out on him—but that hasn't dampened his spirit. He's now on a quest to uncover the truth of his birth and lineage, but he's going to find much more than he bargained for.</p>
                    <h3>Primary Attributes</h3>
                    <ul class=\"bullet\">
                        <li>Strong physical attacks</li>
                        <li>The ability to dash around to avoid foes</li>
                        <li>Fast and furious weapon combos</li>
                    </ul>
                    <h3>Weapons</h3>
                    <p><strong>Primary</strong>: Greatsword, Axe, Hammer</p>
                    <p class=\"mb20\"><strong>Secondary</strong>: Gauntlet</p>
                    <div class=\"img-3col\"><img alt=\"\" src=\"http://nxcache.nexon.net/dn/img/guide/class-guide/warrior-tn-1.jpg\"> <img alt=\"\" src=\"http://nxcache.nexon.net/dn/img/guide/class-guide/warrior-tn-2.jpg\"> <img alt=\"\" src=\"http://nxcache.nexon.net/dn/img/guide/class-guide/warrior-tn-3.jpg\"> </div>
                    <h3 class='clear'>Specialization</h3>
                    <ul class=\"subclass\">
                        <li>
                            <p><strong>Swordsman</strong></p>
                            <p>At level 15 Warriors may choose to become <strong>Swordsmen</strong>. Swordsmen specialize in the use of greatswords and can create long chains of combos that do massive damage. As Swordsmen continue to rise in level, they can further specialize their abilities, choosing to focus on doing massive damage to a single opponent or less damage to many opponents at once.</p><img alt=\"\" src=\"http://nxcache.nexon.net/dn/img/guide/class-guide/subclass-tn-1.jpg\"></li>
                        <li>
                            <p><strong>Mercenary</strong></p>
                            <p>At level 15 Warriors may choose to become <strong>Mercenaries</strong>. Mercenaries do less damage and are much less mobile than Swordsmen. They make up for this however, by being the most heavily armored character in the game. Their primary focus is engaging enemies one-on-one and taking the kind of blows other characters can’t, allowing their friends the opportunity to damage and destroy larger enemies. Mercenaries may use axes or hammers. </p><img alt=\"\" src=\"http://nxcache.nexon.net/dn/img/guide/class-guide/subclass-tn-2.jpg\"> </li>
                    </ul>
                </div> ");
                    break;
                case 'archer':print("<h1>The Archer!</h1>");
                    print("<div id=\"tab-body\" style=\"display: block;\"><h2>Archer</h2><img class=\"fr\" alt=\"\" src=\"http://nxcache.nexon.net/dn/img/guide/class-guide/character-archer.jpg\"> 
                        <p class=\"mb20\">As an Archer, you excel at long-ranged combat, taking out foes using a bow and arrows and using your speed and agility to avoid being hit in return. </p>
                        <h3>Character</h3>
                        <p class=\"mb20\">The Archer is as willowy and flexible as the bow she wields. Like all the elves of Arendel, she's a lover of nature, for in that land, elves who find their destiny ascend to a second life as a tree. She's left her beloved home to embark on the journey to find her Telezia, her destiny. Should she succeed, she will return in honor, to one day join her ancestors by becoming a tree. To fail in her quest, means oblivion, being reduced to nothing more than a pile of dust. </p>
                        <h3>Primary Attributes</h3>
                        <ul class=\"bullet\">
                        <li>Very strong long-range attacks</li>
                        <li>Archers are very quick and can move while using their basic attacks</li>
                        <li>While not armored very well, they have many evasive skills to avoid being hit</li></ul>
                        <h3>Weapons</h3>
                        <p><strong>Primary</strong>: Shortbow, Longbow, Crossbow</p>
                        <p class=\"mb20\"><strong>Secondary</strong>: Quiver</p>
                        <div class=\"img-3col\"><img alt=\"\" src=\"http://nxcache.nexon.net/dn/img/guide/class-guide/archer-tn-1.jpg\"> <img alt=\"\" src=\"http://nxcache.nexon.net/dn/img/guide/class-guide/archer-tn-2.jpg\"> <img alt=\"\" src=\"http://nxcache.nexon.net/dn/img/guide/class-guide/archer-tn-3.jpg\"> </div>
                        <h3 class='clear'>Specialization</h3>
                        <ul class=\"subclass\">
                        <li>
                        <p><strong>Sharpshooter </strong></p>
                        <p>At level 15 Archers may become <strong>Sharpshooters</strong>. Sharpshooters specialize in the use of bows at the expense of their acrobatic skills and melee attacks. As such, they tend to be very vulnerable when up close with an opponent. At range though, there is no class in the game who can do as much damage as a well-played Sharpshooter. </p><img alt=\"\" src=\"http://nxcache.nexon.net/dn/img/guide/class-guide/archer-subclass-tn-1.jpg\"> </li>
                        <li>
                        <p><strong>Acrobat </strong></p>
                        <p>At level 15 Archers may choose to become <strong>Acrobats</strong>. While still excellent long-range attackers, Acrobats give up some of their most damaging bow skills in favor of acquiring a devastating arsenal of lightning-fast kicks and strikes. While still poorly armored, Acrobats are one of the most agile classes, boasting plenty of escape moves that allow them to get in close, do damage and get out before the foe even knows what hit them. </p><img alt=\"\" src=\"http://nxcache.nexon.net/dn/img/guide/class-guide/archer-subclass-tn-2.jpg\"> </li></ul></div>");break;
                case 'cleric':print("<h1>The Cleric!</h1>");
                    print("<div id=\"tab-body\" style=\"display: block;\"><h2>Cleric</h2><img class=\"fr\" alt=\"\" src=\"http://nxcache.nexon.net/dn/img/guide/class-guide/character-cleric.jpg\"> 
                    <p class=\"mb20\">The Cleric is a tough, armored fighter with the ability to both heal and buff friends. He does less damage than most other classes, but his support abilities more than make up for it, making the Cleric a welcome friend in any party.</p>
                    <h3>Character</h3>
                    <p class=\"mb20\">The goddess decrees that evil must be exterminated, and this the Cleric does without question. He does whatever is necessary to further the cause of righteousness. Through his every act of holy violence, he sheds the hypocrisy of his past and family—his untrue father, his cruel stepmother, and his heritage as the bastard son of a line of impoverished noblemen—for the Cleric believes that good can only be born out of bloodshed.</p>
                    <h3>Primary Attributes</h3>
                    <ul class=\"bullet\">
                    <li>Strong defenses</li>
                    <li>The ability to heal and buff friends</li>
                    <li>Can distract multiple foes or pull away a large one, allowing party members to focus on clearing out dungeons</li></ul>
                    <h3>Weapons</h3>
                    <p><strong>Primary</strong>: Mace, Flail, Wand</p>
                    <p class=\"mb20\"><strong>Secondary</strong>: Shield</p>
                    <div class=\"img-3col\"><img alt=\"\" src=\"http://nxcache.nexon.net/dn/img/guide/class-guide/cleric-tn-1.jpg\"> <img alt=\"\" src=\"http://nxcache.nexon.net/dn/img/guide/class-guide/cleric-tn-2.jpg\"> <img alt=\"\" src=\"http://nxcache.nexon.net/dn/img/guide/class-guide/cleric-tn-3.jpg\"> </div>
                    <h3 class='clear'>Specialization</h3>
                    <ul class=\"subclass\">
                    <li>
                    <p><strong>Paladin </strong></p>
                    <p>At level 15 Clerics may choose to become <strong>Paladins</strong>. More than any other class, the Paladin specializes in keeping himself alive. A sort of “armored turtle,” the Paladin is really good at taking a beating to distract monsters in order to give his friends time to destroy them. Their greatest weakness is their low damage and small mana pool that forces them to be very careful when casting spells. </p><img alt=\"\" src=\"http://nxcache.nexon.net/dn/img/guide/class-guide/cleric-subclass-tn-1.jpg\"> </li>
                    <li>
                    <p><strong>Priest</strong></p>
                    <p>At level 15 Clerics may choose to become <strong>Priests</strong>. Unlike Paladins, Priests have larger mana pools and more attack spells at their disposal. That means they can serve as a secondary damage dealer in a party. Their most effective role though, is as a healer. A good Priest in a party keeping everybody alive is often the difference between life and death in a dungeon. </p><img alt=\"\" src=\"http://nxcache.nexon.net/dn/img/guide/class-guide/cleric-subclass-tn-2.jpg\"> </li></ul></div>");break;
                case 'sorceress':print("<h1>The Sorceress!</h1>");
                    print("<div id=\"tab-body\" style=\"display: block;\"><h2>Sorceress</h2><img class=\"fr\" alt=\"\" src=\"http://nxcache.nexon.net/dn/img/guide/class-guide/character-sorceress.jpg\"> 
                    <p class=\"mb20\">The Sorceress specializes in medium-range attacks. While they can’t do as much damage as the Archer, their greatest strength is their ability to inflict various status ailments on enemies. They can freeze them, set them on fire, poison them, or do all sorts of other damage that can kill a lot of monsters over time. They can also equip a variety of off-hand items that allow them to cause different secondary effects.</p>
                    <h3>Character</h3>
                    <p class=\"mb20\">Nobody is smarter, sexier, or witchier than the Sorceress—her own words. She'll perform any spell, fight any monster, and retrieve any lost item, all for the right price. Once, she had the potential to be the greatest of her kind, but she rejected that destiny and decided her time was better spent gambling, but destiny is not so easily thwarted... </p>
                    <h3>Primary Attributes</h3>
                    <ul class=\"bullet\">
                    <li>Medium ranged magical attacks</li>
                    <li>Can freeze, poison and burn foes, making the Sorceress great at controlling crowds of monsters</li>
                    <li>Protect your friends by knocking creatures out of the way</li></ul>
                    <h3>Weapons</h3>
                    <p><strong>Primary</strong>: Staff</p>
                    <p class=\"mb20\"><strong>Secondary</strong>: Grimoire, Orb, Puppet</p>
                    <div class=\"img-3col\"><img alt=\"\" src=\"http://nxcache.nexon.net/dn/img/guide/class-guide/sorceress-tn-1.jpg\"> <img alt=\"\" src=\"http://nxcache.nexon.net/dn/img/guide/class-guide/sorceress-tn-2.jpg\"> <img alt=\"\" src=\"http://nxcache.nexon.net/dn/img/guide/class-guide/sorceress-tn-3.jpg\"> </div>
                    <h3 class='clear'>Specialization</h3>
                    <ul class=\"subclass\">
                    <li>
                    <p><strong>Elementalist </strong></p>
                    <p>At level 15 Sorceresses may choose to become <strong>Elementalists</strong>. Elementalists are the queens of elemental magic and can create walls of ice, poison pits, flame trails and more as they take ultimate control of the battlefield. Although Elementalists have the disadvantage of lower health, they more than compensate with their ultimate damage. When in doubt, let an Elementalist “divide and conquer” the battlefield for you! </p><img alt=\"\" src=\"http://nxcache.nexon.net/dn/img/guide/class-guide/sorceress-subclass-tn-1.jpg\"> </li>
                    <li>
                    <p><strong>Mystic</strong></p>
                    <p>At level 15 Sorceresses may choose to become <span style=\"FONT-WEIGHT: bold\">Mystics</span>. Mystics go far beyond merely using the elements to inflict status ailments. They harness the very force of creation itself such as gravity and black holes to control the crowd, ripping creatures apart, crushing them mercilessly, or just whipping them around to give their friends the chance to slice and dice them. Mystics are well balanced in their damage dealing and survival in a battle.</p><img alt=\"\" src=\"http://nxcache.nexon.net/dn/img/guide/class-guide/sorceress-subclass-tn-2.jpg\"> </li></ul></div>");break;
                case 'tinker':print("<h1>The Tinkerer!</h1>");
                    print("<div id=\"tab-body\" style=\"display: block;\"><h2>Tinkerer</h2><img class=\"fr\" alt=\"\" src=\"http://nxcache.nexon.net/dn/img/guide/class-guide/character-tinkerer.jpg\"> 
                    <p class=\"mb20\">The Tinkerer uses the power of science to control her enemies, summon robots, and provide healing support for her friends. Her well-rounded skillset makes her an excellent addition to any party.</p>
                    <h3>Character</h3>
                    <p class=\"mb20\">Girl genius, quackum enthusiast, time traveler—these are all perfect ways to describe the Tinkerer. She comes from 50 years in the future, a time when the heroes are all gone and Vestinel’s evil influence has corrupted the land. After her time machine crashes near Mana Ridge, she’s left stranded in the present with nothing to rely on but her wits and Alfredo, her giant robot butler. Now she’ll stop at nothing to save the Prophet and set right what once went wrong.</p>
                    <h3>Primary Attributes</h3>
                    <ul class=\"bullet\">
                    <li>Tinkerers use a variety of attacks that hit a wide area from mid- to long-range</li>
                    <li>Tinkerers are flexible heroes with skills to deal damage, heal, and defend their allies</li>
                    <li>Their low Strength and Vitality are offset by strong Agility and Intellect<br></li></ul>
                    <h3>Weapons</h3>
                    <p><strong>Primary</strong>: Cannon, Bubble Blaster</p>
                    <p class=\"mb20\"><strong>Secondary</strong>: Powerglove</p>
                    <div class=\"img-3col\"><img alt=\"\" src=\"http://nxcache.nexon.net/dn/img/guide/class-guide/tinkerer-tn-1.jpg\"> <img alt=\"\" src=\"http://nxcache.nexon.net/dn/img/guide/class-guide/tinkerer-tn-2.jpg\"> <img alt=\"\" src=\"http://nxcache.nexon.net/dn/img/guide/class-guide/tinkerer-tn-3.jpg\"> </div>
                    <h3 class='clear'>Specialization</h3>
                    <ul class=\"subclass\">
                    <li>
                    <p><strong>Engineer </strong></p>
                    <p>At level 15 Tinkerers may become <strong>Engineers.</strong> Engineers command a vast arsenal of rockets, turrets, and robots to deal damage and control the battlefield. In addition to direct-damage skills, the Engineer can also bolster Alfredo, transforming the robo-butler into the ultimate bodyguard.</p><img alt=\"\" src=\"http://nxcache.nexon.net/dn/img/guide/class-guide/tinkerer-subclass-tn-1.jpg\"> </li>
                    <li>
                    <p><strong>Alchemist</strong></p>
                    <p>At level 15 Tinkerers may choose to become <strong>Alchemists.</strong> Masters of all things chemical, Alchemists use various tinctures and tonics to heal allies, poison enemies, and dish out elemental damage. With the power to tip the scales of battle in their party’s favor, Alchemists make excellent all-around supporters.</p><img alt=\"\" src=\"http://nxcache.nexon.net/dn/img/guide/class-guide/tinkerer-subclass-tn-2.jpg\"> </li></ul></div>");break;
                case 'kali':print("<h1>The Kali!</h1>");
                    print("             
                    <div id=\"tab-body\" style=\"display: block;\">
                        <h2>Kali</h2>
                        <img class=\"fr\" alt=\"\" src=\"http://nxcache.nexon.net/dn/img/guide/class-guide/kali/character-kali.jpg\"> 
                        <p class=\"mb20\">The Kali combines fast and fluid melee combat with dark magic that cripples her enemies and bolsters her allies. Her relentless strikes and debilitating de-buffs weaken foes and leave them open to attack.</p>
                        <h3>Character</h3>
                        <p class=\"mb20\">Born beneath the shadow star in a desert town unknown to the rest of Altera, the Kali was trained to harness the power of dark magic from an early age. Her strength was predicted by the ancients, but even they couldn't have imagined what she would become when set to purpose. It wasn't until Dragon Cultists reduced her town to ash and rubble that her destiny became clear.</p>
                        <h3>Primary Attributes</h3>
                        <ul class=\"bullet\">
                            <li>The Kali uses a variety of short and long range attacks depending on her specialization</li>
                            <li>The ability to buff allies</li>
                            <li>Spiritual attacks that deal dark magic damage</li>
                        </ul>
                        <h3>Weapons</h3>
                        <p><strong>Primary</strong>: Fans, Chakrams</p>
                        <p class=\"mb20\"><strong>Secondary</strong>: Focus</p>
                        <div class=\"img-3col\"><img alt=\"\" src=\"http://nxcache.nexon.net/dn/img/guide/class-guide/kali/kali-tn-1.jpg\"> <img alt=\"\" src=\"http://nxcache.nexon.net/dn/img/guide/class-guide/kali/kali-tn-2.jpg\"> <img alt=\"\" src=\"http://nxcache.nexon.net/dn/img/guide/class-guide/kali/kali-tn-3.jpg\"> </div>
                        <h3 class='clear'>Specialization</h3>
                        <ul class=\"subclass\">
                            <li>
                                <p><strong>Screamer</strong></p>
                                <p>At level 15, Kali may become a <strong>Screamer</strong>. Screamers embrace the power of fallen spirits to protect allies and weaken enemies with status effects and continuous damage. Screamers can even become invincible for a short time.</p><img alt=\"\" src=\"http://nxcache.nexon.net/dn/img/guide/class-guide/kali/kali-subclass-tn-1.jpg\"></li>
                            <li>
                                <p><strong>Dancer</strong></p>
                                <p>At level 15, Kali may become a <strong>Dancer</strong>. Dancers unleash a flurry of chakram attacks and magical abilities in a deadly dance that overwhelms enemies. Dancers are lithe and agile, and they dart from enemy to enemy in the blink of an eye.</p><img alt=\"\" src=\"http://nxcache.nexon.net/dn/img/guide/class-guide/kali/kali-subclass-tn-2.jpg\"> </li>
                        </ul>
                    </div>         
                     ");   break;
                case 'assassin':print("<h1>The Assassin!</h1>");
                    print("<div id=\"tab-body\" style=\"display: block;\"><h2>Assassin</h2><img class=\"fr\" alt=\"\" src=\"http://nxcache.nexon.net/dn/img/guide/class-guide/character-assassin.jpg\"> 
                    <p class=\"mb20\">The Assassin is a formidable foe who can out-duel any opponent at both mid and close range. As a master of hand-to-hand combat, as well as the Shadow and Light Arts, his particular set of impressive skills will help parties in any situation.</p>
                    <h3>Character</h3>
                    <p class=\"mb20\"> Both a tragic hero and a villain, the Assassin is the unfortunate victim of time and circumstance. Driven mad by a chance meeting with himself, he travels the world of Altera looking for a way to overcome his darkness. On his quest, he will find that some hidden truths best remain hidden.</p>
                    <h3>Primary Attributes</h3>
                    <ul class=\"bullet\">
                    <li>The Assassin incorporates both physical and magic attacks in his mid - and close -range combat</li>
                    <li>Another versatile class who can help allies and hinder enemies</li>
                    <li>His master is a talking cat</li></ul>
                    <h3>Weapons</h3>
                    <p><strong>Primary</strong>: Scimitar, Dagger</p>
                    <p class=\"mb20\"><strong>Secondary</strong>: Hooks</p>
                    <div class=\"img-3col\"><img alt=\"\" src=\"http://nxcache.nexon.net/dn/img/guide/class-guide/assassin-tn-1.jpg\"> <img alt=\"\" src=\"http://nxcache.nexon.net/dn/img/guide/class-guide/assassin-tn-2.jpg\"> <img alt=\"\" src=\"http://nxcache.nexon.net/dn/img/guide/class-guide/assassin-tn-3.jpg\"> </div>
                    <h3 class='clear'>Specialization</h3>
                    <ul class=\"subclass\">
                    <li>
                    <p><strong>Shinobi</strong></p>
                    <p>At level 15, Assassins can choose to become <strong>Shinobi</strong>. The Shinobi use the scimitar in combination with the use of the Ninja Arts. Their attacks can surpass even the strength of Ninjitsu legends. Their strikes are quick and their movement is quicker.</p><img alt=\"\" src=\"http://nxcache.nexon.net/dn/img/guide/class-guide/assassin-subclass-tn-1.jpg\"></li>
                    <li>
                    <p><strong>Taoist</strong></p>
                    <p>At level 15, Assassins can choose to become a <strong>Taoist</strong>. Master of the Shadow and Light Arts, the Taoist is as versatile as classes get. They can dish damage and heal, almost at the same time. Their buffs can be the do or die of party play.</p><img alt=\"\" src=\"http://nxcache.nexon.net/dn/img/guide/class-guide/assassin-subclass-tn-2.jpg\"> </li></ul></div>");break;
                case 'lencea':print("<h1>The Lencea!</h1>");
                    print("<div id=\"tab-body\" style=\"display: block;\"><h2>Lencea</h2><img class=\"fr\" alt=\"\" src=\"http://nxcache.nexon.net/dn/img/guide/class-guide/character-lencea.jpg\"> 
                    <p class=\"mb20\">The Lencea keeps all enemies at bay with her lengthy and trusted spear. Her skills are easy to combo and even easier to master; her quick strikes and steady hands make her as deadly as any warrior.</p>
                    <h3>Character</h3>
                    <p class=\"mb20\">The Lencea is the reluctant hero of an ill-timed, yet simple delivery quest.  An heiress to the greatest mercenary company in the world, she bears witness to the crumbling of it all when one quest after another unveils a truth she cannot bear. With her sister in tow, she seeks out the only person who will help them rebuild their lives for the better.</p>
                    <h3>Primary Attributes</h3>
                    <ul class=\"bullet\">
                    <li>The Lencea is strong-willed and strong-hearted with a quick head-butt</li>
                    <li>Resilient and steady combo attacks</li>
                    <li>Great at defeating monsters in large groups</li></ul>
                    <h3>Weapons</h3>
                    <p><strong>Primary</strong>: Spear</p>
                    <p class=\"mb20\"><strong>Secondary</strong>: Bracelet</p>
                    <div class=\"img-3col\"><img alt=\"\" src=\"http://nxcache.nexon.net/dn/img/guide/class-guide/lencea-tn-1.jpg\"> <img alt=\"\" src=\"http://nxcache.nexon.net/dn/img/guide/class-guide/lencea-tn-2.jpg\"> <img alt=\"\" src=\"http://nxcache.nexon.net/dn/img/guide/class-guide/lencea-tn-3.jpg\"> </div>
                    <h3 class='clear'>Specialization</h3>
                    <ul class=\"subclass\">
                    <li>
                    <p><strong>Lancer</strong></p>
                    <p>At level 15, the Lencea becomes a <strong>Lancer</strong>. Their unbridled attacks and unconventional magic strike fear in those that they oppose. Lancers are equally skilled in both their own physical and magic prowess.</p><img alt=\"\" src=\"http://nxcache.nexon.net/dn/img/guide/class-guide/lencea-subclass-tn-1.jpg\"></li></ul></div>");break;
                default: print("<h1 class='title'>Please Select a Class To Learn More !</h1>");       
            }    
          ?>              
          </div>  
        </div>   
        <div id="footer">
            <div id="navbar" >
                <ul>
                    <li><a href="index.php" >Home |</a></li>
                    <li><a href="guides.php" >Guides |</a></li>
                    <li><a href="classes.php">Classes |</a></li>
                    <li><a href="skillBuilds.php">Skill Builds |</a></li>
                    <li><a href="music.php">Music |</a></li>
                </ul>
            &copy; 2015 Michael Rallo - SaintSaves <br />
            </div>
        </div>	
	</body>
</html>
