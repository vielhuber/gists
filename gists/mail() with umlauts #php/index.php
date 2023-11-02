mail(
   "vieldav@gmx.de",                                                             // recipient
   "=?UTF-8?B?".base64_encode("ä ö ü ß")."?=",                                   // subject
   "ä ö ü ß",                                                                    // content
   "Content-type: text/plain; charset=utf-8\r\n"
  ."From: =?UTF-8?B?".base64_encode("ä ö ü ß")."?=<david@vielhuber.de>"          // from
);