Simple GitHub WebHook receiver
==============

Simple GitHub WebHook receiver is a very simple, small server-side php script that receives GitHub WebHook requests and then react to them.


Install
-------
After downloading this repo you will need to place the files on the server you intent to receive GitHub WebHook request.  Typically you should place this in its own web folder like: /var/www/deploy.mydomain.com

I normally set it up as a subdomain under a domain I own and update the web server and dns to use setup.  PHP will need to have elevated permissions to utilize the exec function in this script.

Next, you'll need to edit config-sample.php and then save as/rename to config.php.


License
-------
Copyright © 2012 by Eric Schultz.

Issued under the MIT License

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), 
to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, 
and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, 
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER 
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.