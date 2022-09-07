import { PDFDocument, StandardFonts, rgb, degrees } from 'pdf-lib';

export default class Page {
    async load() {
        // load existing pdf
        let url = 'input.pdf';
        let existingPdfBytes = await fetch(url).then(res => res.arrayBuffer());
        let pdfDoc = await PDFDocument.load(existingPdfBytes);

        // add text
        let pages = pdfDoc.getPages();
        let firstPage = pages[0];
        let { width, height } = firstPage.getSize();
        let helveticaFont = await pdfDoc.embedFont(StandardFonts.Helvetica);
        firstPage.drawText('example text', {
            x: 5,
            y: height / 2 + 300,
            size: 50,
            font: helveticaFont,
            color: rgb(0.95, 0.1, 0.1),
            rotate: degrees(-45)
        });

        // get form
        let form = pdfDoc.getForm();

        // fill form
        let testfield1 = form.getTextField('testfield1');
        testfield1.setText('example text');
        let testfield2 = form.getCheckBox('testfield2');
        testfield2.check();

        // embed image
        let emblemUrl = 'example.png';
        let emblemImageBytes = await fetch(emblemUrl).then(res => res.arrayBuffer());
        let emblemImage = await pdfDoc.embedPng(emblemImageBytes);
        let testImageField = form.getButton('testfield3');
        testImageField.setImage(emblemImage);
      
      	// flatten
       	form.flatten();

        // get base64
        let pdfDataUri = await pdfDoc.saveAsBase64({ dataUri: true });

        // embed in iframe src
        // (this is too big to embed in an iframe (on chrome this fails on files bigger than 1.5mb)
        //document.getElementById('pdf').src = pdfDataUri;

        // open/download in new window
        let newBlob = this.base64toBlob(pdfDataUri);
        let data = window.URL.createObjectURL(newBlob);
        let link = document.createElement('a');
        link.href = data;
        //link.download = 'file.pdf';
        link.click();
    }

    base64toBlob(dataURI) {
        let byteString = atob(dataURI.split(',')[1]);
        let ab = new ArrayBuffer(byteString.length);
        let ia = new Uint8Array(ab);
        for (let i = 0; i < byteString.length; i++) {
            ia[i] = byteString.charCodeAt(i);
        }
        return new Blob([ab], { type: 'application/pdf' });
    }
}
