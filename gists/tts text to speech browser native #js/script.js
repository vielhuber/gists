// list voices
speechSynthesis.getVoices().forEach(speech => { console.log(speech); });

// speak
let message = new SpeechSynthesisUtterance('Verteidigungsminister Boris Pistorius hat die Berliner Ukraine-Gespräche mit Europäern und den USA gelobt.');
message.lang = 'de-DE';
message.voice = speechSynthesis.getVoices().filter(voice => voice.name === 'Google Deutsch')[0];
window.speechSynthesis.speak(message);

// stop
setTimeout(() => {
  window.speechSynthesis.cancel();
},2000);
