<template>


<div class="example-full">
  <!-- <button type="button" class="btn btn-danger float-right btn-is-option" @click.prevent="isOption = !isOption">
    <i class="fa fa-cog" aria-hidden="true"></i>
    Options
  </button>
  <h1 id="example-title" class="example-title">Full Example</h1> -->

  <div v-show="$refs.upload3 && $refs.upload3.dropActive" class="drop-active">
    <h3>Soltar archivos para cargar</h3>
  </div>
  <div class="upload3" v-show="!isOption">
    <div class="table-responsive">
      <table class="table table-hover">
        <thead>
          <tr>
            <th>#</th>
            <th>Vista Previa</th>
            <th>Nombre</th>
            <th>Tamaño</th>
            <th>Velocidad</th>
            <th>Estado</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <tr v-if="!files3.length">
            <td colspan="7">
              <div class="text-center p-5">
                <h4>Suelte archivos en cualquier lugar para cargar<br/>o</h4>
                <label :for="name" class="btn btn-lg btn-primary">Seleccione Archivos</label>
              </div>
            </td>
          </tr>
          <tr v-for="(file, index) in files3" :key="file.id">
            <td>{{index}}</td>
            <td>
              <img v-if="file.thumb" :src="file.thumb" width="40" height="auto" />
              <span v-else>No Image</span>
            </td>
            <td>
              <div class="filename">
                {{file.name}}
              </div>
              <div class="progress" v-if="file.active || file.progress !== '0.00'">
                <div :class="{'progress-bar': true, 'progress-bar-striped': true, 'bg-danger': file.error, 'progress-bar-animated': file.active}" role="progressbar" :style="{width: file.progress + '%'}">{{file.progress}}%</div>
              </div>
            </td>
            <td>{{file.size | formatSize}}</td>
            <td>{{file.speed | formatSize}}</td>

            <td v-if="file.error">{{file.error}}</td>
            <td v-else-if="file.success">success</td>
            <td v-else-if="file.active">active</td>
            <td v-else></td>
            <td>
              <div class="btn-group">
                <button class="btn btn-secondary btn-sm dropdown-toggle" type="button">
                  Accion
                </button>
                <div class="dropdown-menu">
                  <!-- <a :class="{'dropdown-item': true, disabled: file.active || file.success || file.error === 'compressing'}" href="#" @click.prevent="file.active || file.success || file.error === 'compressing' ? false :  onEditFileShow(file)">Edit</a> -->
                  <a :class="{'dropdown-item': true, disabled: !file.active}" href="#" @click.prevent="file.active ? $refs.upload3.update(file, {error: 'cancel'}) : false">Cancelar</a>

                  <a class="dropdown-item" href="#" v-if="file.active" @click.prevent="$refs.upload3.update(file, {active: false})">Abortar</a>
                  <a class="dropdown-item" href="#" v-else-if="file.error && file.error !== 'compressing' && $refs.upload3.features.html5" @click.prevent="$refs.upload3.update(file, {active: true, error: '', progress: '0.00'})">Reintentar carga</a>
                  <a :class="{'dropdown-item': true, disabled: file.success || file.error === 'compressing'}" href="#" v-else @click.prevent="file.success || file.error === 'compressing' ? false : $refs.upload3.update(file, {active: true})">Cargar</a>

                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="#" @click.prevent="$refs.upload3.remove(file)">Remover</a>
                </div>
              </div>
            </td>
          </tr>

        </tbody>
      </table>
    </div>
    <div class="example-foorer">
      <div class="footer-status float-right">
   <!--      Drop: {{$refs.upload ? $refs.upload.drop : false}},
        Active: {{$refs.upload ? $refs.upload.active : false}},
        Uploaded: {{$refs.upload ? $refs.upload.uploaded : true}},
        Drop active: {{$refs.upload ? $refs.upload.dropActive : false}} -->
      </div>
      <div class="btn-group">
        <file-upload
          class="btn btn-primary dropdown-toggle"
          :post-action="postAction"
          :extensions="extensions"
          :accept="accept"
          :multiple="multiple"
          :directory="directory"
          :size="size || 0"
          :thread="thread < 1 ? 1 : (thread > 5 ? 5 : thread)"
          :headers="headers"
          :data="data"
          :drop="drop"
          :drop-directory="dropDirectory"
          :add-index="addIndex"
          v-model="files3"
          @input-filter="inputFilter"
          @input-file="inputFile"
          ref="upload3"
          input-id="file3">
          <i class="fa fa-plus"></i>
          Seleccionar
        </file-upload>
   <!--      <div class="dropdown-menu">
          <label class="dropdown-item" :for="name">Add files</label>
          <a class="dropdown-item" href="#" @click="onAddFolader">Add folder</a>
          <a class="dropdown-item" href="#" @click.prevent="addData.show = true">Add data</a>
        </div> -->
      </div>
      <button type="button" class="btn btn-success" v-if="!$refs.upload3 || !$refs.upload3.active" @click.prevent="$refs.upload3.active = true">
        <i class="fa fa-arrow-up" aria-hidden="true"></i>
        Iniciar Carga
      </button>
      <button type="button" class="btn btn-danger"  v-else @click.prevent="$refs.upload3.active = false">
        <i class="fa fa-stop" aria-hidden="true"></i>
        Detener Carga
      </button>
    </div>
  </div>





  <div class="option" v-show="isOption">
    <div class="form-group">
      <label for="accept">Accept:</label>
      <input type="text" id="accept" class="form-control" v-model="accept">
      <small class="form-text text-muted">Allow upload mime type</small>
    </div>
    <div class="form-group">
      <label for="extensions">Extensions:</label>
      <input type="text" id="extensions" class="form-control" v-model="extensions">
      <small class="form-text text-muted">Allow upload file extension</small>
    </div>
    <div class="form-group">
      <label>PUT Upload:</label>
      <div class="form-check">
        <label class="form-check-label">
          <input class="form-check-input" type="radio" name="put-action" id="put-action" value="" v-model="putAction"> Off
        </label>
      </div>
      <div class="form-check">
        <label class="form-check-label">
          <input class="form-check-input" type="radio" name="put-action" id="put-action" value="/upload/put" v-model="putAction"> On
        </label>
      </div>
      <small class="form-text text-muted">After the shutdown, use the POST method to upload</small>
    </div>
    <div class="form-group">
      <label for="thread">Thread:</label>
      <input type="number" max="5" min="1" id="thread" class="form-control" v-model.number="thread">
      <small class="form-text text-muted">Also upload the number of files at the same time (number of threads)</small>
    </div>
    <div class="form-group">
      <label for="size">Max size:</label>
      <input type="number" min="0" id="size" class="form-control" v-model.number="size">
    </div>
    <div class="form-group">
      <label for="minSize">Min size:</label>
      <input type="number" min="0" id="minSize" class="form-control" v-model.number="minSize">
    </div>
    <div class="form-group">
      <label for="autoCompress">Automatically compress:</label>
      <input type="number" min="0" id="autoCompress" class="form-control" v-model.number="autoCompress">
      <small class="form-text text-muted" v-if="autoCompress > 0">More than {{autoCompress | formatSize}} files are automatically compressed</small>
      <small class="form-text text-muted" v-else>Set up automatic compression</small>
    </div>

    <div class="form-group">
      <div class="form-check">
        <label class="form-check-label">
          <input type="checkbox" id="add-index" class="form-check-input" v-model="addIndex"> Start position to add
        </label>
      </div>
      <small class="form-text text-muted">Add a file list to start the location to add</small>
    </div>

    <div class="form-group">
      <div class="form-check">
        <label class="form-check-label">
          <input type="checkbox" id="drop" class="form-check-input" v-model="drop"> Drop
        </label>
      </div>
      <small class="form-text text-muted">Drag and drop upload</small>
    </div>
    <div class="form-group">
      <div class="form-check">
        <label class="form-check-label">
          <input type="checkbox" id="drop-directory" class="form-check-input" v-model="dropDirectory"> Drop directory
        </label>
      </div>
      <small class="form-text text-muted">Not checked, filter the dragged folder</small>
    </div>
    <div class="form-group">
      <div class="form-check">
        <label class="form-check-label">
          <input type="checkbox" id="upload-auto" class="form-check-input" v-model="uploadAuto"> Auto start
        </label>
      </div>
      <small class="form-text text-muted">Automatically activate upload</small>
    </div>
    <div class="form-group">
      <button type="button" class="btn btn-primary btn-lg btn-block" @click.prevent="isOption = !isOption">Confirm</button>
    </div>
  </div>





  <div :class="{'modal-backdrop': true, 'fade': true, show: addData.show}"></div>
  <div :class="{modal: true, fade: true, show: addData.show}" id="modal-add-data" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add data</h5>
          <button type="button" class="close"  @click.prevent="addData.show = false">
            <span>&times;</span>
          </button>
        </div>
        <form @submit.prevent="onAddData">
          <div class="modal-body">
            <div class="form-group">
              <label for="name">Name:</label>
              <input type="text" class="form-control" required id="name"  placeholder="Please enter a file name" v-model="addData.name">
              <small class="form-text text-muted">Such as <code>filename.txt</code></small>
            </div>
            <div class="form-group">
              <label for="type">Type:</label>
              <input type="text" class="form-control" required id="type"  placeholder="Please enter the MIME type" v-model="addData.type">
              <small class="form-text text-muted">Such as <code>text/plain</code></small>
            </div>
            <div class="form-group">
              <label for="content">Content:</label>
              <textarea class="form-control" required id="content" rows="3" placeholder="Please enter the file contents" v-model="addData.content"></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" @click.prevent="addData.show = false">Close</button>
            <button type="submit" class="btn btn-primary">Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>






  <div :class="{'modal-backdrop': true, 'fade': true, show: editFile.show}"></div>
  <div :class="{modal: true, fade: true, show: editFile.show}" id="modal-edit-file" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit file</h5>
          <button type="button" class="close"  @click.prevent="editFile.show = false">
            <span>&times;</span>
          </button>
        </div>
        <form @submit.prevent="onEditorFile">
          <div class="modal-body">
            <div class="form-group">
              <label for="name">Name:</label>
              <input type="text" class="form-control" required id="name"  placeholder="Please enter a file name" v-model="editFile.name">
            </div>
            <div class="form-group" v-if="editFile.show && editFile.blob && editFile.type && editFile.type.substr(0, 6) === 'image/'">
              <label>Image: </label>
              <div class="edit-image">
                <img :src="editFile.blob" ref="editImage" />
              </div>

              <div class="edit-image-tool">
                <div class="btn-group" role="group">
                  <button type="button" class="btn btn-primary" @click="editFile.cropper.rotate(-90)" title="cropper.rotate(-90)"><i class="fa fa-undo" aria-hidden="true"></i></button>
                  <button type="button" class="btn btn-primary" @click="editFile.cropper.rotate(90)"  title="cropper.rotate(90)"><i class="fa fa-repeat" aria-hidden="true"></i></button>
                </div>
                <div class="btn-group" role="group">
                  <button type="button" class="btn btn-primary" @click="editFile.cropper.crop()" title="cropper.crop()"><i class="fa fa-check" aria-hidden="true"></i></button>
                  <button type="button" class="btn btn-primary" @click="editFile.cropper.clear()" title="cropper.clear()"><i class="fa fa-remove" aria-hidden="true"></i></button>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" @click.prevent="editFile.show = false">Close</button>
            <button type="submit" class="btn btn-primary">Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>

<!--   <div class="pt-5">
    Source code: <a href="https://github.com/lian-yue/vue-upload-component/blob/master/docs/views/examples/Full.vue">/docs/views/examples/Full.vue</a>
  </div> -->





</div>

</template>


<script>

Vue.filter('formatSize', function (size) {
  if (size > 1024 * 1024 * 1024 * 1024) {
    return (size / 1024 / 1024 / 1024 / 1024).toFixed(2) + ' TB'
  } else if (size > 1024 * 1024 * 1024) {
    return (size / 1024 / 1024 / 1024).toFixed(2) + ' GB'
  } else if (size > 1024 * 1024) {
    return (size / 1024 / 1024).toFixed(2) + ' MB'
  } else if (size > 1024) {
    return (size / 1024).toFixed(2) + ' KB'
  }
  return size.toString() + ' B'
})

import Cropper from 'cropperjs'
import ImageCompressor from '@xkeshi/image-compressor'
import FileUpload from 'vue-upload-component'


export default {
  components: {
    FileUpload,
    Cropper,
    File
  },
  data:function () {
    return {
      files3: [],
   accept: '',
   extensions: 'gif,jpg,jpeg,png,webp,pdf,doc,docx,ppt,pptx,xls,xlsx,mp4,mov,mp3,dwg,dxf,dwf,bin,bak,HEIC,heic, heif,zip,tif,skp,dgn,dsd,ctb,pln,bpn,gsm,lcf,rar,sdb,pro,mcdx,kmz,kml,gmw,csv,txt,fbx,ls8,ls9,ls10',                                                                                                                                                                                                                                         
      // extensions: ['gif', 'jpg', 'jpeg','png', 'webp'],
      // extensions: /\.(gif|jpe?g|png|webp)$/i,
      minSize: 1024,
      size: 1024 * 1024 * 1024 * 10,
      multiple: true,
      directory: false,
      drop: true,
      dropDirectory: false,
      addIndex: false,
      thread: 3,
      name: 'file3',
      postAction: '../contractsFileAdd',
      putAction: '../contractsFileAdd',
      headers: {
         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
      },
      data: {
         '_token': $('meta[name="csrf-token"]').attr('content'),
         'contractId': this.contractId,
         'typeDoc': this.typeDoc
      },
      autoCompress: 1024 * 1024,
      uploadAuto: false,
      isOption: false,
      addData: {
        show: false,
        name: '',
        type: '',
        content: '',
      },
      editFile: {
        show: false,
        name: '',
      }
    }
  },
 props: {
           contractId: { type: String},
           typeDoc:{type: String}
    },
  watch: {
    'editFile.show'(newValue, oldValue) {
      // 关闭了 自动删除 error
      if (!newValue && oldValue) {
        this.$refs.upload3.update(this.editFile.id, { error: this.editFile.error || '' })
      }
      if (newValue) {
        this.$nextTick(function () {
          if (!this.$refs.editImage) {
            return
          }
          let cropper = new Cropper(this.$refs.editImage, {
            autoCrop: false,
          })
          this.editFile = {
            ...this.editFile,
            cropper
          }
        })
      }
    },
    'addData.show'(show) {
      if (show) {
        this.addData.name = ''
        this.addData.type = ''
        this.addData.content = ''
      }
    },
  },
  methods: {
    inputFilter(newFile, oldFile, prevent) {
      if (newFile && !oldFile) {
        // Before adding a file
        // 添加文件前
        // Filter system files or hide files
        // 过滤系统文件 和隐藏文件
        if (/(\/|^)(Thumbs\.db|desktop\.ini|\..+)$/.test(newFile.name)) {
          return prevent()
        }
        // Filter php html js file
        // 过滤 php html js 文件
        if (/\.(php5?|html?|jsx?)$/i.test(newFile.name)) {
          return prevent()
        }
        // Automatic compression
        // 自动压缩
        if (newFile.file && newFile.type.substr(0, 6) === 'image/' && this.autoCompress > 0 && this.autoCompress < newFile.size) {
          newFile.error = 'compressing'
          const imageCompressor = new ImageCompressor(null, {
            convertSize: Infinity,
            maxWidth: 512,
            maxHeight: 512,
          })
          imageCompressor.compress(newFile.file)
            .then((file) => {
              this.$refs.upload3.update(newFile, { error: '', file, size: file.size, type: file.type })
            })
            .catch((err) => {
              this.$refs.upload3.update(newFile, { error: err.message || 'compress' })
            })
        }
      }
      if (newFile && (!oldFile || newFile.file !== oldFile.file)) {
        // Create a blob field
        // 创建 blob 字段
        newFile.blob = ''
        let URL = window.URL || window.webkitURL
        if (URL && URL.createObjectURL) {
          newFile.blob = URL.createObjectURL(newFile.file)
        }
        // Thumbnails
        // 缩略图
        newFile.thumb = ''
        if (newFile.blob && newFile.type.substr(0, 6) === 'image/') {
          newFile.thumb = newFile.blob
        }
      }
    },
    // add, update, remove File Event
    inputFile(newFile, oldFile) {
      if (newFile && oldFile) {
        // update
        if (newFile.active && !oldFile.active) {
          // beforeSend
          // min size
          if (newFile.size >= 0 && this.minSize > 0 && newFile.size < this.minSize) {
            this.$refs.upload3.update(newFile, { error: 'size' })
          }
        }
        if (newFile.progress !== oldFile.progress) {
          // progress
        }
        if (newFile.error && !oldFile.error) {
          // error
        }
        if (newFile.success && !oldFile.success) {
                this.$emit('insert')
                this.$refs.upload3.remove(newFile) 
        }
      }
      if (!newFile && oldFile) {
        // remove
        if (oldFile.success && oldFile.response.id) {
          // $.ajax({
          //   type: 'DELETE',
          //   url: '/upload/delete?id=' + oldFile.response.id,
          // })
        }
      }
      // Automatically activate upload
      if (Boolean(newFile) !== Boolean(oldFile) || oldFile.error !== newFile.error) {
        if (this.uploadAuto && !this.$refs.upload3.active) {
          this.$refs.upload3.active = true
        }
      }
    },
    alert(message) {
      alert(message)
    },
    onEditFileShow(file) {
      this.editFile = { ...file, show: true }
      this.$refs.upload3.update(file, { error: 'edit' })
    },
    onEditorFile() {
      if (!this.$refs.upload3.features.html5) {
        this.alert('Your browser does not support')
        this.editFile.show = false
        return
      }
      let data = {
        name: this.editFile.name,
      }
      if (this.editFile.cropper) {
        let binStr = atob(this.editFile.cropper.getCroppedCanvas().toDataURL(this.editFile.type).split(',')[1])
        let arr = new Uint8Array(binStr.length)
        for (let i = 0; i < binStr.length; i++) {
          arr[i] = binStr.charCodeAt(i)
        }
        data.file = new File([arr], data.name, { type: this.editFile.type })
        data.size = data.file.size
      }
      this.$refs.upload3.update(this.editFile.id, data)
      this.editFile.error = ''
      this.editFile.show = false
    },
    // add folader
    onAddFolader() {
      if (!this.$refs.upload3.features.directory) {
        this.alert('Your browser does not support')
        return
      }
      let input = this.$refs.upload3.$el.querySelector('input')
      input.directory = true
      input.webkitdirectory = true
      this.directory = true
      input.onclick = null
      input.click()
      input.onclick = (e) => {
        this.directory = false
        input.directory = false
        input.webkitdirectory = false
      }
    },
    onAddData() {
      this.addData.show = false
      if (!this.$refs.upload3.features.html5) {
        this.alert('Your browser does not support')
        return
      }
      let file = new window.File([this.addData.content], this.addData.name, {
        type: this.addData.type,
      })
      console.log(file);
      this.$refs.upload3.add(file)
    }
  }
}
</script>

<style>

.dropdown-menu {
    position: absolute;
    top: 100%;
    left: 0;
    z-index: 1000;
    display: none;
    float: left;
    min-width: 10rem;
    padding: .5rem 0;
    margin: .125rem 0 0;
    font-size: 1rem;
    color: #212529;
    text-align: left;
    list-style: none;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid rgba(0,0,0,.15);
    border-radius: .25rem;
}
.dropdown-item {
    display: block;
    width: 100%;
    padding: .25rem 1.5rem;
    clear: both;
    font-weight: 400;
    color: #212529;
    text-align: inherit;
    white-space: nowrap;
    background: 0 0;
    border: 0;
}

.example-full .btn-group .dropdown-menu {
  display: block;
  visibility: hidden;
  transition: all .2s
}
.example-full .btn-group:hover > .dropdown-menu {
  visibility: visible;
}
.example-full label.dropdown-item {
  margin-bottom: 0;
}
.example-full .btn-group .dropdown-toggle {
  margin-right: .6rem
}
.example-full .filename {
  margin-bottom: .3rem
}
.example-full .btn-is-option {
  margin-top: 0.25rem;
}
.example-full .example-foorer {
  padding: .5rem 0;
  border-top: 1px solid #e9ecef;
  border-bottom: 1px solid #e9ecef;
}
.example-full .edit-image img {
  max-width: 100%;
}
.example-full .edit-image-tool {
  margin-top: .6rem;
}
.example-full .edit-image-tool .btn-group{
  margin-right: .6rem;
}
.example-full .footer-status {
  padding-top: .4rem;
}
.example-full .drop-active {
  top: 0;
  bottom: 0;
  right: 0;
  left: 0;
  position: fixed;
  z-index: 9999;
  opacity: .6;
  text-align: center;
  background: #000;
}
.example-full .drop-active h3 {
  margin: -.5em 0 0;
  position: absolute;
  top: 50%;
  left: 0;
  right: 0;
  -webkit-transform: translateY(-50%);
  -ms-transform: translateY(-50%);
  transform: translateY(-50%);
  font-size: 40px;
  color: #fff;
  padding: 0;
}

.modal-backdrop.fade {
    visibility: hidden;
}
.modal-backdrop.fade {
    opacity: 0;
}
.modal-backdrop {
    position: fixed;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    z-index: 1040;
    background-color: #000;
}
.fade {
    opacity: 0;
    transition: opacity .15s linear;
}
.modal {
    position: fixed;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    z-index: 1050;
    display: none;
    overflow: hidden;
    outline: 0;
}

.fade {
    opacity: 0;
    transition: opacity .15s linear;
}

</style>