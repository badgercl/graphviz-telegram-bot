# Inline Telegram bot for generating directed graphs
This bot is live at https://t.me/graphviz_bot


## Requirements

* PHP >= 5
* Mysql >= 5.5
* Graphviz cli installed 


## Installing

1. Clone the repo in a non-web-accesible place
1. Add a symbolic link in your public_html or html folder pointing to the *web* folder of this project.
1. Give permissions on the *images* folder to allow apache write files and also allow them to be accesible from the web. 
1. Edit the config.php file and provide your bot token, web-accesible path to the bot, and mysql credentials
1. Edit the web/config.php and provide the unix path to the config.php from last point
1. Create a symbolic link from the web/bot folder to a web/botBOTNUMBER. This is not mandatory, but your webhook path shouln't be easy to spot. If you do not care, modify .htaccesss file to allow accesses to the web/bot directory.
1. Setup the webhook pointing to the symbolic link just created.


# TODO
* Improve start method
* Improve logs
* Provide examples
