function FactoryXMLHttpRequest()
{
  if(window.XMLHttpRequest) {
    return new XMLHttpRequest();
  }
  else if (window.ActiveXObject) {
    var msxmls = new Array(
                   'Msxml2.XMLHTTP.5.0',
                   'Msxml2.XMLHTTP.4.0',
                   'Msxml2.XMLHTTP.3.0',
                   'Msxml2.XMLHTTP',
                   'Microsoft.XMLHTTP');

    for (var i = 0; i < msxmls.length; i++) {
      try {
        return new ActiveXObject(msxmls[i]);
      }
      catch (e) {}
    }
  }
  throw new Error("Could not instantiate XMLHttpRequest");
}

function Asynchronous()
{
  this._xmlhttp = new FactoryXMLHttpRequest();
}

function Asynchronous_call(url, id)
{
  var instance = this;
  this._xmlhttp.open('GET', url, true);
  this._xmlhttp.onreadystatechange = function() {
  switch(instance._xmlhttp.readyState) {
    case 1:
      instance.loading();
      break;

    case 2:
      instance.loaded();
      break;

    case 3:
      instance.interactive();
      break;

    case 4:
      instance.complete(instance._xmlhttp.responseText, id);
      break;
    }
  }
  this._xmlhttp.send(null);
}
function Asynchronous_loading() { }
function Asynchronous_loaded() { }
function Asynchronous_interactive() { }
function Asynchronous_complete(responseText, id) { }

Asynchronous.prototype.loading = Asynchronous_loading;
Asynchronous.prototype.loaded = Asynchronous_loaded;
Asynchronous.prototype.interactive = Asynchronous_interactive;
Asynchronous.prototype.complete = Asynchronous_complete;
Asynchronous.prototype.call = Asynchronous_call;