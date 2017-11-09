<h2 class="page-title">Add New Author</h2>
<h5>Insert data to create an new author</h5>
<div class="quark-presence-column left">
    <div class="quark-presence-container content-container presence-block " id="form-body">
        <form method="POST" id="item-form" action="/admin/author/create">
            <div class="quark-presence-column left" id="main_div">
                <div class="quark-presence-container presence-block middle">
                    <div class="title"><p>Name</p>
                        <input placeholder="Name" type="text" class="text_field quark-input" name="name" id="item-name" >
                    </div>
                </div>
                <div class="quark-presence-container presence-block middle">
                    <div class="title"><p>Type</p>
                        <select class="text_field quark-input" name="type" id="item-type">
                            <?php
                            use Models\Author;
                            echo '<option value="' , strtoupper(Author::TYPE_HUMAN) , '">Human</option>';
                            echo '<option value="' , strtoupper(Author::TYPE_MASTER) , '">Master</option>';
                            ?>
                        </select>
                    </div>
                </div>
                <div class="quark-presence-container presence-block middle">
                    <div class="title"><p>Keywords</p>
                        <input placeholder="keywords" type="text" class="text_field quark-input" name="keywords" id="item-keywords">
                    </div>
                </div>
                <div class="quark-presence-container presence-block middle">
                    <div class="title">
                        <p>Description</p>
                        <input placeholder="Description" class="text_field quark-input" name="description" id="item-description"/>
                    </div>
                </div>
            </div>
            <br />
            <div class="quark-presence-container presence-block">
                <br/>
                <button class="quark-button block ok submit-button" type="submit">
					Create
                </button>
            </div>
        </form>
    </div>
</div>
