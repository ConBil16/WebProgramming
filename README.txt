1) Cross-site scripting (XSS) is a vulnerability that enables hackers to inject client-side script into web pages. Explain the potential issue with using $_SERVER["PHP_SELF"] as the form action, and how to avoid that issue.

    When using the PHP_SELF the hacker and type in a different url and use the <script> tag to do anything including redirecting the user to another website on a different server

2) Explain why it's important to have server-side validation, and why you might want both client- and server-side.

    It's important to have server-side validation and possibly both so that your don't have form abuse from hacker or malicious users
