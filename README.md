# spotifyblock

To install place the spotifyblock folder in your /modules/custom/directory for your site
Enable through the admin 'Spotify Block'

or

install using Drush
drush pm-enable spotifyblock

and clear cache
drush cr

A block will be available to be added at /admin/structure/block
The 'Spotify Block' should be added to the content section of your site

To adjust the amount of artists (as initially it may be zero) shown in the block go to /admin/config/content/spotifyblock and select the amount - max 20.

This will display a list of Artists from spotify - this version uses related artists from the API as it doesnt seem possible to just get a list of 'artists'



