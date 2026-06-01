# social-media
Simple social media website

Changed:

Added hidden input on the comment for to get the "return_url" (just the current URL)

On save comment it redirects to said URL instead of just to Index

Index now checks for loads, which also checks if there's a post id,
if there is one, it gets the rest of the params and runs openPost() with it.

----

Removed duplicate image loading code, it now checks if image is present.

Removed two seperate headers, one with and one without the hamburger menu.

Changed README