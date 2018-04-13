<template lang="html">
  <div class="">

  </div>
</template>

<script>
import moment from 'moment'


  // const localDomain = 'http://localhost:8000';
  const localDomain = 'http://www.badtudou.com';
  const token = sessionStorage.getItem('token');
  const userId = sessionStorage.getItem('userId');
  const permissions = sessionStorage.getItem('permissions');


  // methods
  const toTime = function (time) {
    return moment(time).format('YYYY-MM-DD');
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
        // debugger
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
  }

  export default
  {
    localDomain,
    token,
    userId,
    permissions,

    // methods
    toTime,
    getData,
    getNextData,
    computedParams,
  }
</script>


<style lang="css">
</style>
