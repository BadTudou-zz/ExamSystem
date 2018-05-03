<template lang="html">
  <div class="">

  </div>
</template>

<script>
import moment from 'moment'


  // const localDomain = 'http://localhost:8000';
  // const localDomain = 'http://127.0.0.1:8000';
  const localDomain = 'https://www.badtudou.com';
  const token = sessionStorage.getItem('token');
  const userId = sessionStorage.getItem('userId');
  const permissions = sessionStorage.getItem('permissions');
  const isShowLogin = true;


  // methods
  const toTime = function (time) {
    return moment(time).format('YYYY-MM-DD');
  };

  const toServerTime = function (time) {
    return moment(time).format('YYYY-MM-DD hh:mm:ss');
  };

  const getData = function (url, list) {
    const that = this;
    let sumDataList = [];
    if (list) {
      sumDataList = list;
    }
    else {
      sumDataList = [];
    }
    axios({
      method: 'get',
      url: url,
      headers: {
        'Accept': 'application/json',
        'Authorization': sessionStorage.getItem('token'),
      }
    }).then(res => {
      let data = res.data.data;  // conclude links
      let url = res.data.links.next;
      sumDataList = sumDataList.concat(data);

      if (url) {
        getNextData(url, sumDataList);
      }
    }).catch(err => {
      console.log(err);
    })
  };
  const getNextData = function (url, list) {
    const that = this;
    let sumDataList = [];
    if (list) {
      sumDataList = list;
    }
    else {
      sumDataList = [];
    }

    axios({
      method: 'get',
      url: url,
      headers: {
        'Accept': 'application/json',
        'Authorization': sessionStorage.getItem('token'),
      }
    }).then(res => {
      let data = res.data.data;  // conclude links
      let url = res.data.links.next;
      sumDataList = sumDataList.concat(data);

      if (url) {
        getData(url, sumDataList);
      }
      else {
        let sum = sumDataList;
        return sum;
      }
    }).catch(err => {
      console.log(err);
    })
  };


  // search拼接函数
  const computedParams = function (selectedQuesiton, param) {
    let arr = selectedQuesiton;
    let string = '';
    for (let i = 0; i < arr.length; i++) {
      if (i != 0) {
        string += '&' + param + '[' + i + ']' + '=' + arr[i];
      }
      else {
        string += param + '[' + i + ']' + '=' + arr[i];
      }
    }
    return string;
  };

  // 通过ID计算用户名
  const computedUserName = function (id) {
    const that = this;
    let userId = id;
    let userName = '';
    axios({
      method: 'get',
      url: `${localDomain}/api/v1/users/${userId}`,
      headers: {
        'Accept': 'application/json',
        'Authorization': sessionStorage.getItem('token'),
      }
    }).then(res => {
      userName = res.data.data.name;
      return userName;
    }).catch(err => {
      console.log(err)
    })
    return userName;
  };

  export default
  {
    localDomain,
    token,
    userId,
    permissions,

    // methods
    toTime,
    toServerTime,
    getData,
    getNextData,
    computedParams,
    computedUserName,
    isShowLogin,
  }
</script>


<style lang="css">
</style>
