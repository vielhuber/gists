# be aware: sPDFACompatibilityPolicy=1 does often not work with wkhtmltopdf generated pdfs, therefore we use dPDFACompatibilityPolicy=1)
gs -dPDFA -dBATCH -dNOPAUSE -dUseCIEColor -sProcessColorModel=DeviceCMYK -sDEVICE=pdfwrite -dPDFACompatibilityPolicy=1 -sOutputFile=output.pdf input.pdf

