import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';

@Injectable()
export class SpqService {

    constructor(private http: HttpClient) {}

    getQuiz(id: number) {
        return this.http.get('http://localhost/wp/wp-json/quiz/v1/quiz/' + id);
    }

    getQuizes() {
        return this.http.get('http://localhost/wp/wp-json/quiz/v1/quiz/');
    }

    createQuiz(quiz: any) {              
        return this.http.post<any>('http://localhost/wp/wp-json/quiz/v1/quiz/', 
            { quiz : quiz }
        );
    }

    updateQuiz(quiz: any) {
        return this.http.patch<any>('http://localhost/wp/wp-json/quiz/v1/quiz/', 
            { quiz : quiz }
        );
    }
//
//    deleteQuiz(item: any) {
//        return this.http.delete('http://localhost/wp/wp-json/quiz/v1/quiz/' + item.id);
//    }

}
