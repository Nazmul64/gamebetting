import re,base64,json,glob,os
def uri(p): return 'data:image/svg+xml;base64,'+base64.b64encode(open(p,'rb').read()).decode()
h=open('index.html').read();css=open('assets/css/style.css').read();js=open('assets/js/engine.js').read()+open('assets/js/game.js').read()
sub=lambda t:re.sub(r'assets/images/([\w\-]+\.svg)',lambda m:uri('assets/images/'+m.group(1)),t)
css=re.sub(r'url\(\.\./images/([\w\-]+\.svg)\)',lambda m:'url('+uri('assets/images/'+m.group(1))+')',css)
h=re.sub(r'<link[^>]*>','<style>'+css+'</style>',h);h=re.sub(r'<script src="assets/[^"]*"></script>','',h)
C={os.path.basename(p)[:-4]:uri(p) for p in glob.glob('assets/images/cards/*.svg')}
h=sub(h).replace('</body>','<script>var CARDS='+json.dumps(C)+';'+js+'</script></body>')
open('preview.html','w').write(h)
