GURL TranslateScript::GetTranslateScriptURL() {
  GURL translate_script_url;
  // Check if command-line contains an alternative URL for translate service.
  const base::CommandLine& command_line =
      *base::CommandLine::ForCurrentProcess();
  if (command_line.HasSwitch(translate::switches::kTranslateScriptURL)) {
    translate_script_url = GURL(command_line.GetSwitchValueASCII(
        translate::switches::kTranslateScriptURL));
    if (!translate_script_url.is_valid() ||
        !translate_script_url.query().empty()) {
      LOG(WARNING) << "The following translate URL specified at the "
                   << "command-line is invalid: "
                   << translate_script_url.spec();
      translate_script_url = GURL();
    }
  }
  // Use default URL when command-line argument is not specified, or specified
  // URL is invalid.
  if (translate_script_url.is_empty())
    translate_script_url = GURL(kScriptURL);
  translate_script_url = net::AppendQueryParameter(
      translate_script_url,
      kCallbackQueryName,
      kCallbackQueryValue);
  translate_script_url = net::AppendQueryParameter(
      translate_script_url,
      kAlwaysUseSslQueryName,
      kAlwaysUseSslQueryValue);
  translate_script_url = net::AppendQueryParameter(
      translate_script_url,
      kCssLoaderCallbackQueryName,
      kCssLoaderCallbackQueryValue);
  translate_script_url = net::AppendQueryParameter(
      translate_script_url,
      kJavascriptLoaderCallbackQueryName,
      kJavascriptLoaderCallbackQueryValue);
  translate_script_url = AddHostLocaleToUrl(translate_script_url);
  translate_script_url = AddApiKeyToUrl(translate_script_url);
  return translate_script_url;
}