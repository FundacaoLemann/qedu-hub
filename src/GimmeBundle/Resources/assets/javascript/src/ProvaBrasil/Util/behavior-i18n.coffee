###
@requires js/mcc/core/behavior.js

Este behavior deve sempre ser utilizado para enviar textos ao javascript 
É uma forma de desacoplar o envio de textos para o JS dos behaviorsque possuem o comportamento da página.

Todos os textos sobrescrevem textos anteriores e são gravados em um mesmo objeto,
portanto, utilize chaves claras, de preferência com namespaces que representem sua página.
###
mcc.behavior 'i18n', (config) ->    

  ###
  i18nTexts não deve ser conhecido pelos programadores. É onde os textos ficam armazenados.
  para acessar um texto, basta usar window.i18n('chave')
  ###
  
  if window['i18nTexts']
    $.extend(window['i18nTexts'], config)
  else 
    window['i18nTexts'] = config  
    window['i18n'] = (key) ->
      if window['i18nTexts'][key]
        return window['i18nTexts'][key];
      else
        if __DEV__
          console.error(key+' não foi reconhecido como uma chave válida para um texto.');