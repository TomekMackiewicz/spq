<div class="wrap">
    <h1>New quiz</h1>
    <div id="spq-box-wrap">
        <div class="spq-box-container-3">
            <form name="spq_quiz_form" method="post" action="" class="spq-quiz-form">
                <p class="submit spq-form-submit">
                    <input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Save Changes') ?>" disabled />
                </p>
                <div class="spq-box">
                    <h2>Basic info</h2>
                    <div class="spq-inside">
                        <div class="spq-input-wrap">
                            <input name="title" type="text" class="spq-input spq-required-field" autocomplete="off" placeholder="Title" required>
                            <div class="spq-invalid-feedback">Title is required</div>
                        </div>
                        <div class="spq-input-wrap">
                            <textarea name="description" class="spq-textarea" formControlName="description" placeholder="Description"></textarea>
                        </div>                      
                        <div class="spq-input-wrap">
                            <textarea name="summary" class="spq-textarea" formControlName="summary" placeholder="Summary"></textarea>
                        </div>
                    </div>
                </div>
                <div class="spq-box">
                    <h2>Settings</h2>
                    <div class="spq-inside">                     
                        <div class="spq-input-wrap">
                            <input name="duration" type="text" class="spq-input spq-regex-integer" placeholder="Duration">                                   
                            <div class="spq-invalid-feedback">Only numbers are allowed</div>
                        </div> 
                        <div class="spq-input-wrap">
                            <input name="next_submission_after" type="text" class="spq-input spq-regex-integer" placeholder="Gap between submissions">                                   
                            <div class="spq-invalid-feedback">Only numbers are allowed</div>
                        </div> 
                        <div class="spq-input-wrap">
                            <input name="time_active" type="text" class="spq-input spq-regex-integer" placeholder="Enter time active">                                  
                            <div class="spq-invalid-feedback">Only numbers are allowed</div>
                        </div>
                        <div class="spq-input-wrap">
                            <input name="paginated" type="checkbox" id="spq-paginate">
                            <label>Paginated?</label>
                        </div>
                        <div class="spq-input-wrap">
                            <input name="per_page" type="text" id="spq-questions-per-page" class="spq-input spq-regex-integer" placeholder="Questions per page">                                 
                            <div class="spq-invalid-feedback">Only numbers are allowed</div>
                        </div>
                        <div class="spq-input-wrap">
                            <input name="shuffle_questions" type="checkbox">
                            <label>Shuffle questions?</label>
                        </div>
                        <div class="spq-input-wrap">
                            <input name="shuffle_answers" type="checkbox">
                            <label>Shuffle answers?</label>
                        </div>
                        <div class="spq-input-wrap">
                            <input name="immediate_answers" type="checkbox">
                            <label>Immediate answers?</label>
                        </div>
                        <div class="spq-input-wrap">
                            <input name="restrict_submissions" type="checkbox">
                            <label>Restrict submissions?</label>
                        </div>
                        <div class="spq-input-wrap">
                            <input name="allowed_submissions" type="text" class="spq-input spq-regex-integer" placeholder="Number of allowed submissions">                                
                            <div class="spq-invalid-feedback">Only numbers are allowed</div>
                        </div>                        
                    </div>                    
                </div>
            </form>
        </div>
        <div class="spq-box-container-3">
            <div class="spq-box">
                <h2>New question</h2>
                <form name="spq_question_form" method="post" action="" class="spq-question-form">
                    <div id="spq-question-form" class="spq-inside">
                        <div class="spq-input-wrap">
                          <input id="spq-question-title" type="text" class="spq-input spq-required-field" placeholder="Enter title" required>
                          <div class="spq-invalid-feedback">Title is required</div>
                        </div>
                        <div class="spq-input-wrap">
                          <textarea id="spq-question-description" class="spq-textarea" placeholder="Description"></textarea>
                        </div>      
                        <div class="spq-input-wrap">
                          <select id="spq-question-type" class="spq-required-field">
                            <option value="" disabled selected>Type</option>
                            <option value="radio">radio</option>
                            <option value="multi">multi</option>
                            <option value="sort">sort</option>
                            <option value="range">range</option>
                            <option value="select">select</option>
                          </select>
                          <div class="spq-invalid-feedback">Type is required</div>
                        </div>
                        <div class="spq-input-wrap">
                          <textarea id="spq-question-hint" class="spq-textarea" placeholder="Hint"></textarea>
                        </div>
                        <div class="spq-input-wrap">
                            <input id="spq-question-obligatory" type="checkbox">
                            <label>Obligatory?</label>
                        </div>
                        <input type="hidden" id="spq-question-id">
                        <button type="button" id="spq-add-question" class="button button-primary">Add question</button>                            
                    </div>
                </form>
            </div> 
<!--                <div class="spq-box">
                <h2>Answers</h2>
                <div class="spq-inside">
                    <button type="button" class="button button-primary">Add answer</button>
                    <ul class="spq-list-group">
                        <li>
                            <i class="fas fa-chevron-down spq-control-icon">
                            </i>
                            <i class="fas fa-trash-alt spq-control-icon"></i>
                            <ng-template>
                              <i class="fas fa-chevron-up spq-control-icon">
                              </i>
                            </ng-template>
                            <div class="spq-collapse">               
                                <div>
                                    <div class="spq-input-wrap">
                                        <input type="text" class="spq-input" placeholder="Answer" required>
                                        <div>
                                            <div>Title is required</div>
                                        </div>            
                                    </div>
                                    <div class="spq-input-wrap">
                                        <input type="checkbox">
                                        <label>Correct answer</label>
                                    </div>     
                                    <div class="spq-input-wrap">
                                        <textarea class="spq-textarea" placeholder="Message"></textarea>
                                    </div>
                                      <div class="spq-input-wrap">
                                        <input type="text" class="spq-input" placeholder="Points">
                                        <div>
                                            <div>Only numbers are allowed</div>
                                        </div>               
                                      </div>                                                  
                                </div>                                   
                            </div>
                        </li>
                    </ul>      
                </div>
            </div>-->
        </div>
        <div class="spq-box-container-6">
            <div class="spq-box">
                <h2>Preview</h2>
                <div class="spq-inside">
                    <ul id="spq-preview"></ul>
                </div>
            </div>
        </div> 
    </div>
</div>

<!--            <div class="spq-box-container-3">
                <div class="spq-box">
                    <h2>List of questions</h2>
                    <div class="spq-inside">
                        <ul
                          cdkDropList
                          #questionsList="cdkDropList"
                          [cdkDropListData]="questions"
                          [cdkDropListConnectedTo]="[tmpQuestionsList]"
                          class="spq-list-group"
                          (cdkDropListDropped)="drop($event)">

                          <li *ngIf="questions.length==0">
                            <div class="spq-placeholder"></div>
                            
                          </li>

                          <li *ngFor="let question of questions; let i = index" cdkDrag>
                            <div class="spq-placeholder" *cdkDragPlaceholder></div>
                            <span class="spq-badge">{{ i+1 }}</span>                           
                            {{ question.label }}
                            <i class="fas fa-arrows-alt spq-control-icon" cdkDragHandle></i> 
                            <i class="fas fa-trash-alt spq-control-icon" (click)="deleteQuestion($event, 'questions', i)"></i>
                            <i class="far fa-clone spq-control-icon" (click)="cloneQuestion($event, question)"></i>
                            <i class="fas fa-cogs spq-control-icon" (click)="edit($event, question)"></i>
                            <i *ngIf="!listState[i] || listState[i]==0; else chevronUp" 
                               class="fas fa-chevron-down spq-control-icon" 
                               [attr.data-target]="'#questionContent_' + i"
                               (click)="toogleQuestionChevron(i)">
                            </i>
                            <ng-template #chevronUp>
                              <i class="fas fa-chevron-up spq-control-icon" 
                                [attr.data-target]="'#questionContent_' + i"
                                (click)="toogleQuestionChevron(i)">
                              </i>
                            </ng-template>
                            <div class="spq-placeholder" *cdkDragPlaceholder></div>
                            <div class="spq-collapse" [ngClass]="{ 'spq-show': listState[i]==1 }">
                                <p>Desc: {{ question.description }}</p>
                                <p>Hint: {{ question.hint }}</p>
                                <p>Type: {{ question.type }}</p>
                                <p>Obligatory: {{ question.isObligatory }}</p>
                                <p>Answers:</p>
                                <div *ngFor="let answer of question.answers">
                                    <p>Title: {{ answer.label }}</p>
                                    <p>Correct: {{ answer.isCorrect }}</p>
                                    <p>Message: {{ answer.message }}</p>
                                    <p>Points: {{ answer.points }}</p>
                                </div>
                            </div>
                          </li>
                        </ul>
                    </div>
                </div>
                <div class="spq-box">
                    <h2>Temp questions</h2>
                    <div class="spq-inside">
                        <ul
                          cdkDropList
                          #tmpQuestionsList="cdkDropList"
                          [cdkDropListData]="tmpQuestions"
                          [cdkDropListConnectedTo]="[questionsList]"
                          class="spq-list-group"
                          (cdkDropListDropped)="drop($event)">

                          <li *ngIf="tmpQuestions.length==0">
                            <div class="spq-placeholder"></div>
                          </li>

                          <li *ngFor="let question of tmpQuestions; let i = index" cdkDrag>
                            <div class="spq-placeholder" *cdkDragPlaceholder></div>
                            <span class="spq-badge">{{ i+1 }}</span>
                            
                            {{ question.label }}
                            <i class="fas fa-arrows-alt spq-control-icon" cdkDragHandle></i>       
                            <i class="fas fa-trash-alt spq-control-icon" (click)="deleteQuestion($event, 'tmpQuestions', i)"></i>
                          </li>
                        </ul>                        
                    </div>
                </div>
            </div>-->
<!--        </div>
    </form>
</div>-->
