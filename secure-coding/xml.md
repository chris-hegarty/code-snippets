

XML External Entities is on the OWASP Top Ten

XML files can 
-potentially expose confidential information from the server
-result in denial of service attacks
-make external requests
-do remote code execution

XML Basics

XML is a markup language based on Standard Generalized Markup Language (SGML).

XML documents optionally accept DTDs or Document Type Definitions, which can be used to define entities, which can 
point to external resources.

XML External Entity Attacks

-XML External Entity Injection
--information disclosure
--can include internal and external resources
--can perform external requests
--with PHP, you can possibly do remote code executions

-XML External Entity Expansion - Trying to deplete the server of resources/memory

SOAP protocol is based on XML


