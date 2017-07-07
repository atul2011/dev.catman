<div class="quark-presence-column">
    <div class="quark-presence-container content-container presence-block " id="form-body">
        <form method="POST" id="form" action="/admin/author/create">
            <div class="quark-presence-column left" id="main_div">
                <div class="quark-presence-container presence-block middle " id="form-div">
                    <div class="title"><p>Name</p>
                        <input placeholder="Name" type="text" class="text_field quark-input" name="name" id="name" >
                    </div>
                </div>
                <div class="quark-presence-container presence-block  middle" id="form-div">
                    <div class="title"><p>Type</p>
                        <input placeholder="Type" type="text" class="text_field quark-input" name="type" id="type" >
                    </div>
                </div>
                <div class="quark-presence-container presence-block middle" id="form-div">
                    <div class="title"><p>Keywords</p>
                        <input placeholder="keywords" type="text" class="text_field quark-input" name="keywords" id="keywords">
                    </div>
                </div>
                <div class="quark-presence-container presence-block middle" id="form-div">
                    <div class="title">
                        <p>Description</p>
                        <input placeholder="Description" class="text_field quark-input" name="description" id="description"/>
                    </div>
                </div>
            </div>
            <br />
            <div class="quark-presence-container presence-block" id="form-div">
                <br/>
                <button class="quark-button block ok submit-button" type="submit">
					Create
                </button>
            </div>
        </form>
    </div>
</div>