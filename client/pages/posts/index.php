<div class="card">
  <div class="head">
    <h3>Posts</h3>
    <div class="custom-button" onclick="openModalAdd()">Add Article</div>
  </div>
  <div class="body">
    <div class="tabs">
      <input name="nav" type="radio" class="nav publish-radio" id="publish-tab" checked="checked" />
      <div class="page publish-page">
        <div class="page-contents">
          <h1 class="text-green pb-10">Publish</h1>
          <div class="showData"></div>
          <div class="pagination"></div>
        </div>
      </div>
      <label class="nav" for="publish-tab">
        <span class="text-green">
          <i class='bx bx-task icon'></i>
          Publish
        </span>
      </label>

      <input name="nav" type="radio" class="draft-radio" id="draft-tab" />
      <div class="page draft-page">
        <div class="page-contents">
          <h1 class="text-blue pb-10">Draft</h1>
          <div class="showData"></div>
          <div class="pagination"></div>
        </div>
      </div>
      <label class="nav" for="draft-tab">
        <span class="text-blue"><i class='bx bx-task-x icon'></i>
          Draft
        </span>
      </label>

      <input name="nav" type="radio" class="trash-radio" id="trash-tab" />
      <div class="page trash-page">
        <div class="page-contents">
          <h1 class="text-red pb-10">Trash</h1>
          <div class="showData"></div>
          <div class="pagination"></div>
        </div>
      </div>
      <label class="nav" for="trash-tab">
        <span class="text-red">
          <i class='bx bx-trash icon'></i>
          Trash
        </span>

      </label>
    </div>
  </div>
</div>

<div id="modal" class="modal">
    <div class="modal-content">
        <span onclick="closeModal()" class="close">&times;</span>
        <h2 id="modal-title">Add/Edit Article</h2>
        <form id="articleForm">
          <input type="hidden" name="id" >
          <label for="title">Title:</label>
          <input type="text" id="title" name="title" >

          <label for="content">Content:</label>
          <textarea id="content" name="content" rows="4" ></textarea>

          <label for="category">Category:</label>
          <input type="text" id="category" name="category" >

          <label>Status:</label>
          <div id="status" class="radio-buttons">
            <input type="radio" id="publish" name="status" value="Publish" >
            <label for="publish">Publish</label>

            <input type="radio" id="draft" name="status" value="Draft" >
            <label for="draft">Draft</label>
          </div>
          <div id="button-submit">
            <button type="submit">Submit</button>
          </div>
        </form>
    </div>
</div>

<script>
  const baseUrl   = 'http://localhost:8000/api/article/';
  let url         = baseUrl;
  let status      = 'Publish';

  $(document).ready(function () {
    getArticle();
    
    publishTab.click(function () {
      status  = 'Publish';
      url     = baseUrl;
      getArticle();
    });

    draftTab.click(function () {
      status  = 'Draft';
      url     = baseUrl;
      getArticle();
    });

    trashTab.click(function () {
      status  = 'Trash';
      url     = baseUrl;
      getArticle();
    });

  
    $(window).click(function (event) {
        if (event.target === modal[0]) {
            closeModal();
        }
    });

    $("form").submit(function(event) {
        event.preventDefault();

        var formData = $(this).serialize();
        var form = this;
        
        var id = $("form > input[name='id']").val();
        $.ajax({
            type: id != '' ? 'PUT' : 'POST',
            url: baseUrl + id,
            data: formData,
            success: function(response) {
                $(".error-message").remove();
            
                if (response.error) {
                  $.each(response.message, function(field, message) {
                    $.each(message, function(index, value){
                      $("form > #" + field).after('<span class="error-message">' + value + '<br/></span>');
                    })
                  });
                } else {
                  alert("Success add article");
                  var selectedValue = $("input[name='status']:checked").val();
                  $("#" + selectedValue.toLowerCase() + "-tab").prop('checked', true);
                  status  = selectedValue;
                  url     = baseUrl;
                  getArticle();
                  form.reset();
                }

            },
        });
    });
  });

  const publishTab  = $('#publish-tab');
  const draftTab    = $('#draft-tab');
  const trashTab    = $('#trash-tab');

  function changePage(changeUrl) {
    url = changeUrl;
    getArticle();
  }

  function getArticle() {
    $.ajax({
      url: url,
      type: 'GET',
      data: {
        status: status,
      },
      dataType: 'json',
      success: function(data) {
        let no = 1;
        let table = '<table>' +
                    '<thead>' +
                      '<tr>' +
                        '<th>No</th>' +
                        '<th>Title</th>' +
                        '<th>Content</th>' +
                        '<th>Category</th>' +
                        '<th>Action</th>' +
                      '</tr>' +
                    '</thead>' +
                    '<tbody>';
        $.each(data.data, function(index, value) {
          table += '<tr>' + 
                    '<td>' + no + '</td>' +
                    '<td>' + value.title + '</td>' +
                    '<td>' + value.content + '</td>' +
                    '<td>' + value.category + '</td>' +
                    '<td>' +
                      '<button onclick="openModalPre(\'' + value.id + '\')" class="icon-button"><i class="bx bx-show-alt icon-preview"></i></button>' +
                      '<button onclick="openModalEdit(\'' + value.id + '\')" class="icon-button"><i class="bx bxs-edit-alt icon-edit"></i></button>' +
                      '<button class="icon-button" onclick="deletePost(\'' + value.id + '\')"><i class="bx bx-trash-alt icon-trash"></i></button>' +
                    '</td>';
                  '</tr>';
          no++;
        });
        table += '</tbody>' +
            '</table>';

        let pagination = '';
        $.each(data.meta.links, function(index, value){
          if (value.url != null) {
            var isActive = value.active ? 'active' : '';
            pagination += '<a href="javascript:void(0)" onclick="changePage(\'' + value.url + '\')" class="pageButton ' + isActive + '">' +
                          value.label +
                        '</a>';
          }
        });

        $(".pagination").html(pagination);
        $(".showData").html(table);
      }
    });
  }

  const modal           = $('#modal');

  function openModalAdd() {
      modal.css('display', 'block');
      $("#button-submit").css('display', 'block');
      $("#modal-title").text("Add Article");
  }

  function openModalPre(id) {
      modal.css('display', 'block');
      $("#button-submit").css('display', 'none');
      $("#modal-title").text("Preview Article");
      $.ajax({
        url: baseUrl + id,
        method: 'GET',
        success: function (data) {
          $("form > #title").val(data.title);
          $("form > #content").val(data.content);
          $("form > #category").val(data.category);

          if (data.status === "Publish") {
              $("#publish").prop("checked", true);
              $("#draft").prop("checked", false);
          } else if (data.status === "Draft") {
              $("#publish").prop("checked", false);
              $("#draft").prop("checked", true);
          }
        },
      });
  }

  function openModalEdit(id) {
      modal.css('display', 'block');
      $("#button-submit").css('display', 'block');
      $("#modal-title").text("Edit Article");

      $.ajax({
        url: baseUrl + id,
        method: 'GET',
        success: function (data) {
          $("form > input[name='id']").val(data.id);
          $("form > #title").val(data.title);
          $("form > #content").val(data.content);
          $("form > #category").val(data.category);

          if (data.status === "Publish") {
              $("#publish").prop("checked", true);
              $("#draft").prop("checked", false);
          } else if (data.status === "Draft") {
              $("#publish").prop("checked", false);
              $("#draft").prop("checked", true);
          }
        },
      });

  }

  function closeModal() {
      modal.css('display', 'none');
      $(".error-message").remove();
      $("form > input[name='id']").val("");
      $("form > #title").val("");
      $("form > #content").val("");
      $("form > #category").val("");
      $("form > #publish").prop("checked", false);
      $("form > #draft").prop("checked", false);
  }
  
  function deletePost(id) {
    const confirmation = confirm('Are you sure you want to delete this item?');

    if (confirmation) {
      $.ajax({
        url: baseUrl + id,
        method: 'DELETE',
        success: function () {
          trashTab.prop('checked', true);
          status  = 'Trash';
          url     = baseUrl;
          getArticle();
        },
      });
    }
  }
</script>

