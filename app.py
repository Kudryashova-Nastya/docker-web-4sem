import time
from flask import render_template
import redis
from flask import Flask

from flask import request

from flask import Flask, redirect, url_for, request
app = Flask(__name__)

app = Flask(__name__)
cache = redis.Redis(host='redis', port=6379)

def get_hit_count():
    retries = 5
    while True:
        try:
            return cache.incr('hits')
        except redis.exceptions.ConnectionError as exc:
            if retries == 0:
                raise exc
            retries -= 1
            time.sleep(0.5)

@app.route('/')
def hello():
    count = get_hit_count()
    return 'Hello from Docker! I have been seen {} times.\n'.format(count)

@app.route('/sale/<transaction_id>')
def get_sale(transaction_id=0):
  return "The transaction is "+str(transaction_id)

@app.route('/test')
def helloTest():
    ddd = get_hit_count()
    # обратиться ко внешнему сервису, чтобы он отправил смс
    # у смс сервиса есть  API
    # нам нужно подменить оригинальный API/ROUTE на наш МОК
    #ENV_SMS_API_ROUTE=http://localhost/8081/sms-send/
    # ENV_SMS_API_ROUTE=http://original
    # {"id":"123213", "status_code":12321}
    return 'test {} \n '.format(ddd)


# 

@app.route('/docker')
def dock():
   return 'i love docker'

@app.route('/dashboard/<name>')
def dashboard(name):
   return 'welcome %s' % name

@app.route('/login',methods = ['POST', 'GET'])
def login():
   if request.method == 'POST':
      user = request.form['name']
      return redirect(url_for('dashboard',name = user))
   else:
      user = request.args.get('name')
      return render_template('login.html')

if __name__ == '__main__':
       app.run(debug = True)
