# disallow all (printing, editing, ...)
pdftk input.pdf output output.pdf owner_pw "supersecret"

# allow more
pdftk input.pdf output output.pdf owner_pw "supersecret" allow Printing allow ModifyContents

# options
Printing – Top Quality Printing
DegradedPrinting – Lower Quality Printing
ModifyContents – Also allows Assembly
Assembly
CopyContents – Also allows ScreenReaders
ScreenReaders
ModifyAnnotations – Also allows FillIn
FillIn
AllFeatures – Allows the user to perform all of the above, and top quality printing.