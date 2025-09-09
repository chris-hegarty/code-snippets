### Table Basics

Resources:

Custom HTML emails with an email expert | Kevin Powell podcast with Mark Robbins
https://www.youtube.com/watch?v=MHnTpN0g7ko

Good Email Code 
https://www.goodemailcode.com/email-code/template

MDN: HTML table basics:
https://developer.mozilla.org/en-US/docs/Learn/HTML/Tables/Basics


```html

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>

    <style>

        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }

        /*To change the space between table cells, use the CSS border-spacing property on the table element:*/
        /*Default is 2px*/
        table {
            width: 100%;
            max-width: 640px;
            margin-inline: auto;
        }

        td {
            background-color: #a5acad;
        }

        .img-full {
            width: 100%;
            height: 100%;
            padding: 0px;
        }

        img {
            max-width: 100%;
            height: auto;
        }

        .content {
            padding: 20px;
        }

    </style>

</head>

<body>

<table>

    <!-- MDN Docs: "The explicit use of the <tbody> element helps the browser to create the intended table structure, avoiding unwanted results." -->
    <!-- For email purposes we are wrapping the whole thing in a row and data element.-->
    <tbody>
    <tr>
        <td>
            <!-- ================================================= -->
            <!-- Begin EACH NEW SECTION as a new table + table row:-->
            <!-- ================================================= -->
            <table>
                <tr>

                    <!--Everything between the td element is the CONTENT OF THE CELL.-->
                    <!--It can contain other elements you need. divs, p, img, ul/li, links... -->
                    <td>
                        <div class="fw-container">
                            <img src="./trees.webp" alt="trees">
                        </div>
                    </td>

                </tr>
            </table>

            <!-- ================================================= -->
            <!-- Begin EACH NEW SECTION as a new table + table row:-->
            <!-- ================================================= -->
            <table>
                <tr>
                    <!--Everything between the td element is the content of the cell.-->
                    <!--It can contain other elements you need. divs, p, img, ul/li, links.... -->
                    <td>
                        <div class="content">
                            <h2>First heading.</h2>
                            <p>Here is some text. Here is some more, a lot more text to show that this is all in one p
                                tag. And yep sorry I'm gonna lorem ipsum to test this tag. Lorem Ipsum is simply dummy
                                text of the printing and typesetting industry. Lorem Ipsum has been the industry's
                                standard dummy text ever since the 1500s, when an unknown printer took a galley of type
                                and scrambled it to make a type specimen book. It has survived not only five centuries,
                                but also the leap into electronic typesetting, remaining essentially unchanged. It was
                                popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum
                                passages, and more recently with desktop publishing software like Aldus PageMaker
                                including versions of Lorem Ipsum.</p>
                        </div>
                    </td>
                </tr>
            </table>

            <!-- ================================================= -->
            <!-- Begin EACH NEW SECTION as a new table + table row:-->
            <!-- ================================================= -->
            <table>
                <tr>
                    <!--Everything between the td element is the content of the cell.-->
                    <!--It can contain other elements you need. divs, p, img, ul/li, links... -->
                    <td>
                        <div class="content">
                            <h2>Second heading.</h2>
                            <p>Here is some text. Here is some more, a lot more text to show that this is all in one p
                                tag. And yep sorry I'm gonna lorem ipsum to test this tag. Lorem Ipsum is simply dummy
                                text of the printing and typesetting industry. Lorem Ipsum has been the industry's
                                standard dummy text ever since the 1500s, when an unknown printer took a galley of type
                                and scrambled it to make a type specimen book. It has survived not only five centuries,
                                but also the leap into electronic typesetting, remaining essentially unchanged. It was
                                popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum
                                passages, and more recently with desktop publishing software like Aldus PageMaker
                                including versions of Lorem Ipsum.</p>
                        </div>
                    </td>

                </tr>
            </table>

            <!-- ================================================= -->
            <!-- Begin EACH NEW SECTION as a new table + table row:-->
            <!-- ================================================= -->
            <table>
                <tr>
                    <!--Everything between the td element is the content of the cell.-->
                    <!--It can contain other elements you need. divs, p, img, ul/li, links..-->
                    <td>

                        <!-- Begin two columns here-->
                        <table width="600" cellpadding="0" cellspacing="0" border="0" class="container">
                            <tr>
                                <td width="300" class="mobile" align="center" valign="top">
                                    <div class="content">
                                        <h2>Grid One heading.</h2>
                                        <p>Here is some text. Here is some more, a lot more text to show that this is all in one p
                                            tag. And yep sorry I'm gonna lorem ipsum to test this tag. Lorem Ipsum is simply dummy
                                            text of the printing and typesetting industry. Lorem Ipsum has been the industry's
                                            standard dummy text ever since the 1500s, when an unknown printer took a galley of type
                                            and scrambled it to make a type specimen book. It has survived not only five centuries,
                                            but also the leap into electronic typesetting, remaining essentially unchanged. It was
                                            popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum
                                            passages, and more recently with desktop publishing software like Aldus PageMaker
                                            including versions of Lorem Ipsum.</p>
                                    </div>
                                </td>
                                <td width="300" class="mobile" align="center" valign="top">
                                    <div class="content">
                                        <h2>Grid Two heading.</h2>
                                        <p>Here is some text. Here is some more, a lot more text to show that this is all in one p
                                            tag. And yep sorry I'm gonna lorem ipsum to test this tag. Lorem Ipsum is simply dummy
                                            text of the printing and typesetting industry. Lorem Ipsum has been the industry's
                                            standard dummy text ever since the 1500s, when an unknown printer took a galley of type
                                            and scrambled it to make a type specimen book. It has survived not only five centuries,
                                            but also the leap into electronic typesetting, remaining essentially unchanged. It was
                                            popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum
                                            passages, and more recently with desktop publishing software like Aldus PageMaker
                                            including versions of Lorem Ipsum.</p>
                                    </div>
                                </td>
                            </tr>
                        </table>

                    </td>
                </tr>
            </table>

            <!-- Close the outer wrapping elements:-->
        </td>
    </tr>
    </tbody>

</table>

</body>
</html>
```