const fs = require('fs');

const jsonFiles = fs.readdirSync('.').filter(f => f.endsWith('.json'));
for (const jf of jsonFiles) {
  const content = fs.readFileSync(jf, 'utf8');
  if (content.includes('play-btn') || content.includes('717cefcbbef9')) {
    console.log('Found play-btn in JSON:', jf);
  }
}
